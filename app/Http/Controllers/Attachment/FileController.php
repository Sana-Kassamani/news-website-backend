<?php

namespace App\Http\Controllers\Attachment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function addNewsAttachment($attachment){

        if(!Storage::exists("NewsAttachment")){
            Storage::makeDirectory("NewsAttachment");
            }
        return Storage::putFile("NewsAttachment", $attachment);
    }
}
