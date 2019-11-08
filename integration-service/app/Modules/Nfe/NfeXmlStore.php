<?php


namespace App\Modules\Nfe;

use stdClass;
use Illuminate\Support\Facades\Storage;

class NfeXmlStore
{

    /** @var string */
    private $path = 'nfe';

    /** @var string */
    private $extension = 'xml';

    /** @var string */
    private $accessKey;

    /** @var string */
    private $xmlBase64;

    /** @var string */
    private $relativePath;

    /** @var NfeXmlParser */
    private $parser;

    public function __construct(stdClass $nfe)
    {
        $this->accessKey = $nfe->access_key;
        $this->xmlBase64 = $nfe->xml;
    }

    public function store(): string
    {
        $this->relativePath = "$this->path/{$this->accessKey}.$this->extension";

        $this->parser = new NfeXmlParser($this->xmlBase64);

        Storage::disk('local')->put($this->relativePath, $this->parser->getString());

        return $this->relativePath;
    }

    public function getParser(): NfeXmlParser
    {
        return $this->parser;
    }

    public function getRelativePath()
    {
        return $this->relativePath;
    }



}
