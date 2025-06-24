<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Lesson;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function getUserId(){
        $user=User::find(auth()->id());
        return response()->json($user);
    }
    public function userRegisterProgress()
    {
        $lessons=Lesson::all();

        foreach($lessons as $lesson){
            $progress=new Progress();

            $progress->user_id=auth()->id();
            $progress->lesson_id=$lesson->id;
            $progress->status_id=1;

            $progress->save();
        }
        return response()->json('success');

    }
    public function changePassword(Request $request){
        $user = User::find(auth()->id());
        if ($request->has('old_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json("fail");
            }
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json("success");
    }

    public function changeAvatar(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $path = $request->file('image')->store('user');

        $user = User::find(auth()->id());

        if ($user->avatar != 'user/user_avatar.png') {
            Storage::delete($user->avatar);
        }

        $user->avatar = $path;
        $user->save();

        return response()->json($user);
    }
    public function deleteUser(){
        $user=User::find(auth()->id());
        $user->delete();
    }


    public function outAllUsers(){
        $users=User::orderBy('created_at','desc')->get();
        return UserResource::collection($users);
    }
}
