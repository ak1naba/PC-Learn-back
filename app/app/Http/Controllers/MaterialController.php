<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lesson;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MaterialController extends Controller
{

    public function uploadFileTheory(Lesson $lesson, Request $request){
       $path=$request->file('image')->store('lessons/materials');

        $lesson->materials()->create([
            'part_img'=>$path,
            'relative_element'=>0,
            'position_x'=>0,
            'position_y'=>0,
        ]);

        return response()->json('success');
    }

    public function deleteFileAny(Material $material){
        Storage::delete($material->part_img);
        $material->delete();
        return response()->json(['message' => 'Материал успешно удален'], 200);
    }

    public function uploadFileRelative(Lesson $lesson, Request $request){
        $path=$request->file('image')->store('lessons/materials');

        $lesson->materials()->create([
            'part_img'=>$path,
            'relative_element'=>1,
            'position_x'=>0,
            'position_y'=>0,
        ]);
    }
    public function uploadFileDaughter(Lesson $lesson, Request $request){
        $path=$request->file('image')->store('lessons/materials');

        $lesson->materials()->create([
            'part_img'=>$path,
            'relative_element'=>0,
            'position_x'=>0,
            'position_y'=>0,
        ]);
    }
    public function updateMaterial(Material $material,Request $request){
        $material->position_x=$request['position_x'];
        $material->position_y=$request['position_y'];

        $material->save();

        return response()->json('success');
    }
}
