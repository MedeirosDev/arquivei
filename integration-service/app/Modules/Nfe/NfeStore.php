<?php


namespace App\Modules\Nfe;


use App\Models\Nfe;
use Illuminate\Support\Collection;

class NfeStore
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

    public function store()
    {
        foreach ($this->nfeResponse->getData() as $nfe) {
            $storedXml = new NfeXmlStore($nfe);

            $storedXml->store();

            $amount = 0;

            if (empty($storedXml->getParser()->getObject()->NFe) === false) {
                $amount = $storedXml->getParser()->getObject()->NFe->infNFe->total->ICMSTot->vNF;
            } else {
                $amount = $storedXml->getParser()->getObject()->infNFe->total->ICMSTot->vNF;
            }

            $nfe = Nfe::create([
                'access_key' => $nfe->access_key,
                'amount' => $amount,
                'xml' => $storedXml->getRelativePath(),
            ]);

            $this->nfes->push($nfe);
        }

        return $this->nfes;
    }



}
