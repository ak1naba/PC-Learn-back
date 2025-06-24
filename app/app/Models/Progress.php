<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Связи с дргоуй моделью
use App\Models\User;
use App\Models\Status;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
            "user_id",
            "lesson_id",
            "status_id",
        ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }
}
