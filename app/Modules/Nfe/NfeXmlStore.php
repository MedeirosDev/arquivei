<?php


namespace App\Modules\Nfe;

use App\Models\Nfe as NfeModel;
use App\Models\NfeFailure as NfeFailureModel;
use stdClass;
use Illuminate\Support\Facades\Storage;
use Exception;

class NfeXmlStore
{

    /** @var string */
    private $path = 'nfe';

    /** @var string */
    private $pathForFailures = 'nfe_failures';

    /** @var string */
    private $extension = 'xml';

    /**  @var stdClass  */
    private $nfe;

    /**  @var mixed NfeModel | NfeFailureModel */
    private $storedDatabase;

    /** @var string */
    private $storedFile;


    public function __construct(stdClass $nfe)
    {
        $this->nfe = $nfe;
    }


    public function store(): bool
    {
        if ($this->canStore()) {

            $this->storedFile = $this->storeFile($this->getRelativePath());
            $this->storedDatabase = $this->storeDatabase($this->storedFile);

        } else {
            $this->storedFile = $this->storeFile($this->getRelativePathForFailures());

            $this->storedDatabase = $this->storeDatabaseFailure(
                $this->storedFile,
                'Already processed previously'
            );
        }

        return ($this->storedDatabase instanceof NfeModel);
    }

    private function getRelativePath(): string
    {
        return "$this->path/{$this->nfe->access_key}.$this->extension";
    }

    private function getRelativePathForFailures(): string
    {
        return "$this->pathForFailures/{$this->nfe->access_key}.$this->extension";
    }

    private function canStore(): bool
    {
        $nfeModel = NfeModel::byAccessKey($this->nfe->access_key)->first();

        return ($nfeModel === null);
    }

    private function storeDatabase(string $xml): NfeModel
    {
        return NfeModel::create([
            'access_key' => $this->nfe->access_key,
            'amount' => $this->nfe->infNFe->total->ICMSTot->vNF,
            'xml' => $xml,
        ]);
    }

    private function storeDatabaseFailure(string $xml, string $message): NfeFailureModel
    {
        return NfeFailureModel::create([
            'access_key' => $this->nfe->access_key,
            'xml' => $xml,
            'message' => $message,
        ]);
    }

    private function storeFile($path): string
    {
        Storage::disk('local')->put($path, $this->nfe->xml);
        return $path;
    }

}
