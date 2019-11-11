<?php


namespace App\Modules\Nfe;


use Illuminate\Support\Collection;

class NfeStore
{
    /** @var Collection */
    private $nfes;

    public function __construct(Collection $nfes)
    {
        $this->nfes = $nfes;
    }

    public function store(): void
    {
        foreach ($this->nfes as $nfe) {
            $NfeXmlStore = new NfeXmlStore($nfe);
            $NfeXmlStore->store();
        }
    }

}
