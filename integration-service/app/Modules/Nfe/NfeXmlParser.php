<?php


namespace App\Modules\Nfe;

use stdClass;

class NfeXmlParser
{
    /** @var string */
    private $base64;

    /** @var string */
    private $string;

    /** @var stdClass */
    private $object;

    public function __construct(string $base64)
    {
        $this->base64 = $base64;
        $this->string = base64_decode($this->getBase64());
        $this->object = $this->convertXmlStringToObject($this->getString());
    }

    public function getBase64(): string
    {
        return $this->base64;
    }

    public function getString(): string
    {
        return $this->string;
    }

    public function getObject(): stdClass
    {
        return $this->object;
    }

    private function convertXmlStringToObject(String $xml): stdClass
    {
        return json_decode(
            json_encode(
                (array) simplexml_load_string($xml)
            )
        );
    }


}
