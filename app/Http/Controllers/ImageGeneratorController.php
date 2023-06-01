<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzelHttpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ImageGeneratorController extends Controller
{
    public function index()
    {
        return Inertia::render('ImageGenerator');
    }
    public function generateImage(Request $request)
    {
        $client = new Client([
            'verify' => false,
            // 'verify' => 'C:/php8/cacert.pem',
        ]);
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' .config('services.chatgpt')
        ];
        $body = json_encode($request->all());

        $req = new GuzzelHttpRequest('POST', 'https://api.openai.com/v1/images/generations', $headers, $body);
        $res = $client->sendAsync($req)->wait();
        return response()->json(json_decode($res->getBody()->getContents()));
    }
}
