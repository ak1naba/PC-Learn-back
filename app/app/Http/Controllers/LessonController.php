<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Http\Request;

//Связь с моделью
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    //Вывод информации всех уроков
    public function index(){
        $lessons=Lesson::orderby('created_at','desc')->with([
            'materials.state'
            ])->get();

        return LessonResource::collection($lessons);
    }
    // Вывод информации по конкретному уроку
    public function getLesson(string $url_title)
    {
        $lesson=Lesson::select("*")->where("title",$url_title)->with([
            'materials.state'
        ])->first();
        return new LessonResource($lesson);
    }

    //Серверная валидация
    private const LESSON_VALIDATOR=[
        'title'=>'required|max:255',
        'theory'=>'required',
        'type_lesson_id'=>'required',
        'hard_binding'=>'required|boolean',
    ];
    private const LESSON_ERRORS=[
        'required'=>'Должно быть заполнено',
        'max'=>'Не длинее :max',
        'boolean'=>'Логический тип данных',
    ];
    // Добавить задание
    public function LessonAdd(Request $request){
        $validated=$request->validate(self::LESSON_VALIDATOR,
            self::LESSON_ERRORS);

        $lesson=Lesson::create([
            'title'=>$validated['title'],
            'theory'=>$validated['theory'],
            'type_lesson_id'=>$validated['type_lesson_id'],
            'hard_binding'=>$validated['hard_binding'],
        ]);
        $lessonId=$lesson->id;

        $users=User::all();
        foreach ($users as $user){
            $progress=new Progress();

            $progress->user_id=$user->id;
            $progress->lesson_id=$lessonId;
            $progress->status_id=1;

            $progress->save();
        }
    }
    //Удалить задание
    public function LessonDestroy(Lesson $lesson){
        $lesson->delete();
    }
    // Изменить задание
    public function LessonEdit(Lesson $lesson, Request $request){
        $validated=$request->validate(self::LESSON_VALIDATOR,
            self::LESSON_ERRORS);

        $lesson->title=$validated['title'];
        $lesson->theory=$validated['theory'];
        $lesson->type_lesson_id=$validated['type_lesson_id'];
        $lesson->hard_binding=$validated['hard_binding'];

        $lesson->save();
    }

}
