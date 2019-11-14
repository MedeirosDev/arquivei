<?php

namespace Tests\Feature;

use App\Http\Resources\NfeResource;
use App\Models\NfeSuccesses;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NfeControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $route = [
        'show' => '',
        'download' => '',
    ];

    private $access_key = 'TEST3511088393285400013355001000000114184078';

    private $nfe;

    public function setUp(): void
    {
        parent::setUp();

        $this->route['show'] = "api/nfe/{$this->access_key}";
        $this->route['download'] = "api/download/{$this->access_key}";

        $this->nfe = $this->createNfe($this->access_key, 658.35)->refresh();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        Storage::disk('local')->deleteDirectory('nfe_test');
    }

    public function testShow()
    {
        $response = $this
            ->beLogged()
            ->beJson()
            ->get($this->route['show']);

        $response
            ->assertOk()
            ->assertJson(
                (new NfeResource($this->nfe))->toArray()
            );
    }

    public function testDownload()
    {
        $response = $this
            ->beLogged()
            ->beJson()
            ->get($this->route['download']);

        $response->assertOk()
            ->assertHeader('content-type', 'text/plain; charset=UTF-8')
            ->assertHeader('content-disposition', "attachment; filename={$this->access_key}.xml");

        $this->assertEquals('<xml></xml>', $response->streamedContent());

    }

    public function testUnauthenticated()
    {
        $response = $this
            ->beJson()
            ->get($this->route['show']);

        $response
            ->assertUnauthorized()
            ->assertJson(['message' => 'Unauthorized']);
    }

    public function testNotFound()
    {
        $response = $this
            ->beLogged()
            ->beJson()
            ->get($this->route['show'] . 'N');

        $response
            ->assertNotFound()
            ->assertJson(['message' => 'Not found']);
    }


    private function createNfe(string $access_key, float $amount = 0): NfeSuccesses
    {
        NfeSuccesses::byAccessKey($access_key)->delete();

        $relativePath = "nfe_test/{$access_key}.xml";

        Storage::disk('local')->put($relativePath, '<xml></xml>');

        return NfeSuccesses::create([
            'access_key' => $access_key,
            'amount' => $amount,
            'xml' => $relativePath,
        ]);
    }
}
