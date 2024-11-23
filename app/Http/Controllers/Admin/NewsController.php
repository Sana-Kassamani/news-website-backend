<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NewsItem;


class NewsController extends Controller
{
    public function getNews(){
        $news = NewsItem::all();
        if($news)
        {
            return response()->json([
                "message"=> "No news yet"
            ]);

        }
        return response()->json([
            "news"=> $news
        ]);
    }
}
