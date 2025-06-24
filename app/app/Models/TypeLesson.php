<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Связи с дргоуй моделью
use App\Models\Lesson;
class TypeLesson extends Model
{
    use HasFactory;

    protected $fillable=[
        "type",
    ];
    public function lesson(){
        return $this->hasMany(Lesson::class);
    }
}
