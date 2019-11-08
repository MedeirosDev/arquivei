<?php


namespace App\Modules\Nfe;


class Nfe
{

    public function getAndStore(int $cursor = 0): void
    {
        $request = new NfeRequest();

        $response = $request->get($cursor);

        $store = new NfeStore($response);

        $store->store();

        if ($response->getCount() > 0) {
            $this->getAndStore($response->getNextCursor());
        } else {
            // @todo create store last cursor
        }

    }

}
