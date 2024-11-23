<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable=["user_id","news_item_id","content"];
}
