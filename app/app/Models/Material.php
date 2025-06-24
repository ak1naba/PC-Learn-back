<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Связи с дргоуй моделью
use App\Models\Lesson;
use App\Models\State;

class Material extends Model
{
    use HasFactory;

    protected $fillable=[
        "part_img",
        "relative_element",
        "position_x",
        "position_y",
    ];
    public function lesson(){
        return $this->belongsTo(Lesson::class, "lesson_id","id");
    }
    public function state(){
        return $this->hasMany(State::class);
    }
}
