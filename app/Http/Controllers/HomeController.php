<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlShortRequest;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $urls = ShortUrl::where('user_id', Auth::id())->paginate(10);

        return view('home', compact('urls'));
    }

    public function shortUrl(UrlShortRequest $urlShortRequest)
    {
        $insertData = [
            'user_id' => Auth::id(),
            'original_url' => $urlShortRequest->input('original_url')
        ];

        $this->generateUniqueShortUrl($insertData);

        $data = ShortUrl::create($insertData);

        return redirect()->route('home');
    }

    public function link($slug)
    {
        $link = ShortUrl::where('url_code', $slug)->firstOrFail();

        $link->click_count++;

        $link->save();

        return redirect($link->original_url);
    }

    private function generateUniqueShortUrl(&$insertData)
    {
        do {
            $code = substr(md5(uniqid(rand(), true)), 0, 6) . Str::random(6);
            $shortUrl = url('/') . '/link/' . $code;
        } while (ShortUrl::where('short_url', $shortUrl)->exists());

        $insertData['short_url'] = $shortUrl;
        $insertData['url_code'] = $code;
    }
}
