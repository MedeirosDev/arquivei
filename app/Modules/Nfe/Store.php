<?php


namespace App\Modules\Nfe;

use App\Models\NfeSuccesses;
use App\Models\NfeFailures;
use Illuminate\Support\Facades\Storage;
use MedeirosDev\Arquivei\Parsers\XmlParser;
use MedeirosDev\Arquivei\Stores\StoreInterface;

class Store implements StoreInterface
{
    /** @var XmlParser */
    private $nfe;

    /** @var string */
    private $extension = 'xml';


    public function store(XmlParser $nfe): bool
    {
        $this->nfe = $nfe;

        if ($this->canStore()) {

            $this->storeDatabase();
            $this->storeFile($this->getRelativePath());
            return true;
        }

        $this->storeDatabaseFailure('Already processed previously');
        $this->storeFile($this->getRelativePathForFailures());
        return false;
    }

    private function canStore(): bool
    {
        $nfeModel = NfeSuccesses::byAccessKey($this->nfe->accessKey)->first();

        return ($nfeModel === null);
    }

    private function storeFile($path): void
    {
        Storage::disk('local')->put($path, $this->nfe->xml);
    }

    private function storeDatabase(): void
    {
        NfeSuccesses::create([
            'access_key' => $this->nfe->accessKey,
            'amount' => $this->nfe->object->infNFe->total->ICMSTot->vNF,
            'xml' => $this->getRelativePath(),
        ]);
    }

    private function storeDatabaseFailure(string $message): void
    {
        NfeFailures::create([
            'access_key' => $this->nfe->accessKey,
            'message' => $message,
            'amount' => $this->nfe->object->infNFe->total->ICMSTot->vNF,
            'xml' => $this->getRelativePathForFailures(),
        ]);
    }

    private function getRelativePath(): string
    {
        return config('arquivei.path_successes') . $this->nfe->accessKey . '.' . $this->extension;
    }

    private function getRelativePathForFailures(): string
    {
        return config('arquivei.path_failures') . $this->nfe->accessKey . '.' . $this->extension;
    }
}
