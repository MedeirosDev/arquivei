<?php


namespace App\Modules\Nfe;

use Spatie\Url\Url;
use stdClass;

class NfeResponse
{
    /** @var int */
    private $code;

    /** @var array */
    private $body;


    public function __construct($request)
    {
        $this->code = (int) $request->getStatusCode();
        $this->body = json_decode($request->getBody()->getContents());
    }

    public function code(): int
    {
        return $this->code;
    }

    public function getData(): array
    {
        return $this->body->data;
    }

    public function getCount(): int
    {
        return (int) $this->body->count;
    }

    public function getPreviousCursor(): int
    {
        return (int) Url::fromString($this->body->page->previous)->getQueryParameter('cursor');
    }

    public function getNextCursor(): int
    {
        return (int) Url::fromString($this->body->page->next)->getQueryParameter('cursor');
    }
}
