<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lesson extends Model
{
    use HasFactory;

    protected $fillable=[
        "title",
        "theory",
        "type_lesson_id",
        "hard_binding",

    ];
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    public function typeLesson(){
        return $this->belongsTo(TypeLesson::class);
    }
    public function progress(){
        return $this->belongsTo(Progress::class);
    }
}
