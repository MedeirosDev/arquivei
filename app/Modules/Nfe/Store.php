<?php


namespace App\Modules\Nfe;

use App\Models\Nfe as NfeModel;
use App\Models\NfeFailure as NfeFailureModel;
use Illuminate\Support\Facades\Storage;
use MedeirosDev\Arquivei\Parsers\XmlParser;
use MedeirosDev\Arquivei\Stores\StoreInterface;

class Store implements StoreInterface
{
    /** @var XmlParser */
    private $nfe;

    /** @var string */
    private $extension = 'xml';

    /** @var array  */
    private $path = [
        'successes' => 'nfe/',
        'failures' => 'nfe/failures/',
    ];

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
        $nfeModel = NfeModel::byAccessKey($this->nfe->accessKey)->first();

        return ($nfeModel === null);
    }

    private function storeFile($path): void
    {
        Storage::disk('local')->put($path, $this->nfe->xml);
    }

    private function storeDatabase(): void
    {
        NfeModel::create([
            'access_key' => $this->nfe->accessKey,
            'amount' => $this->nfe->object->infNFe->total->ICMSTot->vNF,
            'xml' => $this->getRelativePath(),
        ]);
    }

    private function storeDatabaseFailure(string $message): void
    {
        NfeFailureModel::create([
            'access_key' => $this->nfe->accessKey,
            'xml' => $this->getRelativePathForFailures(),
            'message' => $message,
        ]);
    }

    private function getRelativePath(): string
    {
        return $this->path['successes'] . $this->nfe->accessKey . '.' . $this->extension;
    }

    private function getRelativePathForFailures(): string
    {
        return $this->path['failures'] . $this->nfe->accessKey . '.' . $this->extension;
    }
}
