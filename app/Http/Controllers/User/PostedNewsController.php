<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Attachment\FileController;
use App\Models\User;
use App\Models\NewsItem;
use App\Models\Article;

class PostedNewsController extends Controller
{
    public function getNewsArray($user_id){
        // ideally user_id can be derived from jwt decode
        // here provided in url
        $user=User::find($user_id);
        if(!$user)
        {
            return response()->json([
                "message"=> "Invalid credentials"
            ],401);
        }
        //get all news in db
        $news = NewsItem::all();
        if(!$news)
        {
            return response()->json([
                "message"=> "No news yet"
            ],404);

        }
        // use collection to filter out news that are for ages above of that of user
        $filtered = collect($news)->filter(function (NewsItem $value, int $key) use ($user){
            return $value->minimum_age <= $user->age;
        });
        return $filtered;
    }

    public function getUsersNews($user_id){
        $filtered = $this->getNewsArray($user_id);
        return response()->json([
            "user_news"=> $filtered
        ],200);
        }


    public function postArticles(Request $request,$user_id){

        $new_article_param=[
            "content"=> $request->content,
            "user_id"=> $user_id,
            "news_item_id"=> $request->news_item_id,
        ];
        foreach($new_article_param as $key => $value)
        {
            if (empty($value) && $value !== '0'){
                return response()->json([
                    "message"=> "All fields are required"
                ],400);
            }
        }

        $news_item= $this->getNewsArray($user_id)->contains("id", $request->news_item_id);
        if(!$news_item){
            return response()->json([
                "message"=> "No news found"
            ],404);
        }
        $attachment= $request->file('attachment');
        if($attachment){
            $file_control= new FileController();
            $path= $file_control->addArticleAttachment($attachment);
            $new_article_param["attachment_path"]=$path;
        }
        
        $new_article=Article::create($new_article_param);

        return response()->json([
            "news"=> $news_item,
            "new article"=> $new_article 
        ],200);
    }
    
}
