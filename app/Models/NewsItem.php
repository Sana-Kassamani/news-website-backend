<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
   protected $fillable=["title","content","minimum_age","user_id"];

}
