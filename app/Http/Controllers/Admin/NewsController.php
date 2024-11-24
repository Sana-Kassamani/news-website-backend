<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Attachment\FileController;
use Exception;
use App\Models\NewsItem;


class NewsController extends Controller
{
    // public function getNews(){
    //     $news = NewsItem::all();
    //     if(!$news)
    //     {
    //         return response()->json([
    //             "message"=> "No news yet"
    //         ]);

    //     }
    //     return response()->json([
    //         "news"=> $news
    //     ]);
    // }


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
        $attachment= $request->file('attachment');
        if($attachment){
            $file_control= new FileController();
            $path= $file_control->addNewsAttachment($attachment);
            $new_item_param["attachment_path"]=$path;
        }
        
        $new_item=NewsItem::create($new_item_param);
        return response()->json([
            "news"=> $new_item
        ],200);
        
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
        if($request->attachment){
        {
            $file_control= new FileController();
            try {
                $path=$file_control->editNewsAttachment($existing_news->attachmnet_path,$request->attachment);
                $item_param["attachment_path"]=$path;
            } catch (Exception $e) {
                return response()->json([
                    "message"=> "Edit news attachment failed",
                    "error"=> $e->getMessage()
                ],404);
            }
        }
        }
        $updated_news = $existing_news->update($item_param);
        return response()->json([
            "updated_news"=> $existing_news
        ],200);
    }

    public function deleteNews($id){
        $news_item_to_delete = NewsItem::find($id);
        if(!$news_item_to_delete)
        {
            return response()->json([
                "message"=> "News not found"
            ],404);
        }
        if($news_item_to_delete->attachment_path)
        {
            $file_control= new FileController();
            try {
                $file_control->deleteNewsAttachment($news_item_to_delete->attachment_path);
            } catch (Exception $e) {
                return response()->json([
                    "message"=> "Deleted news attachment failed",
                    "error"=> $e->getMessage()
                ],404);
            }
        }
        $news_item_to_delete->delete();
        return response()->json([
            "message"=> "Deleted news"
        ],200);
    }

}
