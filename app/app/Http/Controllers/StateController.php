<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StateController extends Controller
{
    public function createState(Material $material, Request $request){
        $path=$request->file('image')->store('lessons/states');

        $material->state()->create([
            'part_img'=>$path,
        ]);

        return response()->json('success');
    }

    public function deleteState(State $state)
    {
        Storage::delete($state->part_img);
        $state->delete();
        return response()->json(['message' => 'Материал успешно удален'], 200);
    }
}
