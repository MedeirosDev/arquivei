<?php


namespace App\Modules\Nfe;


use MedeirosDev\Arquivei\Arquivei;

class Nfe
{

    public function GetAndStoreAllNfe()
    {
        $store = new Store();
        $arquivei = new Arquivei($store);
        $arquivei->requestAllAndStore();
    }

}
