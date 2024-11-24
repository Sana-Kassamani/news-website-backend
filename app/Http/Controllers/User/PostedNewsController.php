<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Models\User;
use App\Models\NewsItem;
use App\Models\Article;

class PostedNewsController extends Controller
{
    public function getUsersNews($user_id){
        // ideally user_id can be derived from jwt decode
        // here provided in url
        $user=User::find($user_id);
        if(!$user)
        {
            return response()->json([
                "message"=> "Invalid credentials"
            ]);
        }
        //get all news in db
        $news = NewsItem::all();
        if(!$news)
        {
            return response()->json([
                "message"=> "No news yet"
            ]);

        }
        // use collection to filter out news that are for ages above of that of user
        $filtered = collect($news)->filter(function (NewsItem $value, int $key) use ($user){
            return $value->minimum_age <= $user->age;
        });
        return response()->json([
            "user_news"=> $filtered
        ]);
        }
    
}
