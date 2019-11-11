<?php


namespace App\Modules\Nfe;


class Nfe
{

    public function getAndStore(int $cursor = 0): void
    {
        $response = $this->get($cursor);
        $this->store($response);

        if ($response->getCount() > 0) {
            $this->getAndStore($response->getNextCursor());
        } else {
            // @todo create store last cursor
        }

    }

    private function get($cursor): NfeResponse
    {
        $request = new NfeRequest();
        $response = null;

        try {
            $response = $request->get($cursor);
        } catch (\Exception $e) {
            dd($e);
        }

        return $response;
    }

    private function store(NfeResponse $response): void
    {
        $nfes = (new NfeParser($response))->parse();

        (new NfeStore($nfes))->store();
    }

}
