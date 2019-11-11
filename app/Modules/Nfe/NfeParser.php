<?php


namespace App\Modules\Nfe;


use Illuminate\Support\Collection;

class NfeParser
{
    /** @var NfeResponse */
    private $nfeResponse;

    /** @var Collection */
    private $nfes;

    public function __construct(NfeResponse $nfeResponse)
    {
        $this->nfeResponse = $nfeResponse;
        $this->nfes = new Collection();
    }

    /**
     * @return Collection
     */
    public function parse(): Collection
    {
        foreach ($this->nfeResponse->getData() as $nfe) {
            $parsedNfe = new NfeXmlParser($nfe->xml, $nfe->access_key);

            $this->nfes->push($parsedNfe->getObject());
        }

        return $this->nfes;
    }

    /**
     * @return Collection
     */
    public function getNfes(): Collection
    {
        return $this->nfes;
    }
}
