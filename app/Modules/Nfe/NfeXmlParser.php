<?php


namespace App\Modules\Nfe;

use stdClass;

class NfeXmlParser
{
    /** @var string */
    private $base64;

    /** @var string */
    private $xml;

    /** @var stdClass */
    private $object;

    /** @var stdClass */
    private $access_key;

    /**
     * NfeXmlParser constructor.
     * @param string $base64
     * @param string $accessKey
     */
    public function __construct(string $base64, string $accessKey)
    {
        $this->base64 = $base64;
        $this->access_key = $accessKey;
        $this->xml = base64_decode($this->base64);
        $this->object = $this->makeObject();
    }

    /**
     * @return string
     */
    public function getBase64(): string
    {
        return $this->base64;
    }

    /**
     * @return string
     */
    public function getXml(): string
    {
        return $this->xml;
    }

    /**
     * @return stdClass
     */
    public function getObject(): stdClass
    {
        return $this->object;
    }

    /**
     * @return stdClass
     */
    private function makeObject(): stdClass
    {
        $object = $this->parse($this->getXml());

        if (empty($object->infNFe) === true) {
            $object = $object->NFe;
        }

        $object->access_key = $this->access_key;
        $object->xml = $this->xml;

        return $object;
    }

    /**
     * @param String $xml
     * @return stdClass
     */
    private function parse(String $xml): stdClass
    {
        return json_decode(
            json_encode(
                (array) simplexml_load_string($xml)
            )
        );
    }


}
