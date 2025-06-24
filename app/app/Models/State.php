<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Связь с другой моделью
use App\Models\Material;
class State extends Model
{
    use HasFactory;

    protected $fillable=[
        'part_img',
    ];
    public function materials(){
        return $this->belongsTo(Material::class, "material_id","id");
    }
}
