<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    protected $table = 'forum_threads';
    protected $fillable = ['user_id','name','email','title','status'];

    public function messages()
    {
        return $this->hasMany(ForumMessage::class, 'thread_id')->orderBy('created_at','asc');
    }
}
