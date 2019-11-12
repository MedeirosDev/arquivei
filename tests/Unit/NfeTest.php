<?php

namespace Tests\Unit;


use App\Modules\Nfe\Nfe;
use Tests\TestCase;

class NfeTest extends TestCase
{

    public function testNfe()
    {
        $nfe = new Nfe();

        $nfe->GetAndStoreAllNfe();


        $this->assertTrue(true);
    }
}
