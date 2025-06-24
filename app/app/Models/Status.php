<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Связи с дргоуй моделью
use App\Models\Progress;

class Status extends Model
{
    use HasFactory;

    protected $fillable=[
        "status",
        ];

    public function progress(){
        return $this->hasMany(Progress::class);
    }
}
