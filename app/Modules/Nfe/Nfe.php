<?php


namespace App\Modules\Nfe;


use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use MedeirosDev\Arquivei\Arquivei;

class Nfe
{

    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings->first();
    }

    public function GetAndStoreAllNfe()
    {
        $store = new Store();

        $arquivei = new Arquivei($store);

        $responses = $arquivei->requestAllAndStore($this->settings->last_cursor);

        $lastCursor = Arr::last($responses)->nextCursor;

        $this->storeLastCursor($lastCursor);
    }

    private function storeLastCursor(int $cursor = 0): void
    {
        $this->settings->update([ 'last_cursor' => $cursor]);
        Config::set('arquivei.last_cursor', $cursor);
    }

}
