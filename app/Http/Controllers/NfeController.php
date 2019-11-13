<?php

namespace App\Http\Controllers;

use App\Models\NfeSuccesses;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class NfeController extends Controller
{
    public function show(string $access_key)
    {
        $nfe = NfeSuccesses::byAccessKey($access_key)->first();

        if ($nfe) {
            $nfe->xml = route('nfe.download', ['access_key' => $access_key]);
            return response()->json($nfe, Response::HTTP_OK);
        }

        return abort(404);
    }

    public function download(string $access_key)
    {
        $nfe = NfeSuccesses::byAccessKey($access_key)->first();

        if ($nfe && Storage::disk('local')->exists($nfe->xml)) {
            return Storage::disk('local')->download($nfe->xml, "{$access_key}.xml");
        }

        return abort(404);
    }
}
