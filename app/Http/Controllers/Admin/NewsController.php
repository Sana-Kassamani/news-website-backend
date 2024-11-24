<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NewsItem;


class NewsController extends Controller
{
    public function getNews(){
        $news = NewsItem::all();
        if(!$news)
        {
            return response()->json([
                "message"=> "No news yet"
            ]);

        }
        return response()->json([
            "news"=> $news
        ]);
    }


    public function createNews(Request $request){
        $new_item_param=[
            "title"=> $request->title,
            "content"=> $request->content,
            "minimum_age"=> $request->minimum_age,
            "user_id"=> $request->user_id,
        ];
        foreach($new_item_param as $key => $value)
        {
            if (empty($value) && $value !== '0'){
                return response()->json([
                    "message"=> "All fields are required"
                ],400);
            }

        }
        $new_item=NewsItem::create($new_item_param);
        return response()->json([
            "news"=> $new_item
        ]);
    }

    public function editNews(Request $request,$id){
        $existing_news=NewsItem::find($id);
        if(!$existing_news)
        {
            return response()->json([
                "message"=> "News Item to edit doesn't exist"
            ],404);

        }
        $item_param=[
            "id"=> $existing_news->id,
            "title"=> $request->title ?  $request->title : $existing_news->title ,
            "content"=> $request->content ? $request->content : $existing_news->content,
            "minimum_age"=> $request->minimum_age ? $request->minimum_age : $existing_news->minimum_age,
            "user_id"=> $request->user_id ? $request->user_id : $existing_news->user_id,
        ];

        $updated_news = $existing_news->update($item_param);
        return response()->json([
            "updated_news"=> $existing_news
        ]);
    }

}
