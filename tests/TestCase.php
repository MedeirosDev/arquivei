<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function beLogged(): self
    {
        $this->withHeaders([
            'x-api-id' => env('ARQUIVEI_API_ID'),
            'x-api-key' => env('ARQUIVEI_API_KEY'),
        ]);

        return $this;
    }

    public function beJson(): self
    {
        $this->withHeaders([
            'content-type' => 'application/json',
            'accept' => 'application/json',
        ]);

        return $this;
    }
}
