<?php

namespace App\Http\Controllers\Attachment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
class FileController extends Controller
{
    public function addNewsAttachment($attachment){

        if(!Storage::exists("NewsAttachment")){
            Storage::makeDirectory("NewsAttachment");
            }
        return Storage::putFile("NewsAttachment", $attachment);
    }
    public function deleteNewsAttachment($attachment_path){

        if(Storage::exists($attachment_path)){
            try {
                Storage::delete($attachment_path);

            } catch (Exception $e) {
                throw new Exception("Failed to delete the attachment: " . $e->getMessage());
            }
        }
        else{
            throw new Exception("No attachment found at the specified path.");
        }
    }
    public function editNewsAttachment($old_attachment_path=null,$new_attachment){
        if($old_attachment_path){
            $this->deleteNewsAttachment($old_attachment_path);
        }
       
        $this->addNewsAttachment($new_attachment);
    }
    // public function addNewsAttachment($attachment){

    //     if(!Storage::exists("NewsAttachment")){
    //         Storage::makeDirectory("NewsAttachment");
    //         }
    //     return Storage::putFile("NewsAttachment", $attachment);
    // }
}
