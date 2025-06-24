<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgressResource;
use App\Models\Lesson;
use App\Models\Progress;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function registerUserProgress(){
        $lessons=Lesson::all();

        foreach($lessons as $lesson){
            $progress=new Progress();

            $progress->user_id=Auth::user()->id;
            $progress->lesson_id=$lesson->id;
            $progress->status_id=1;

            $progress->save();

        }
        return response()->json([
            'success' => $lessons,
            'message' => 'Success message'
        ], 400);
    }

    public function outUserProgressLessons(Request $request){
        $type = $request->type_lesson;
        if (!$type) {
            // обработка ошибки, если параметр не передан
        }
        $finalType = 1;
        if ($type == 'practic') {
            $finalType = 2;
        }
        $user = Auth::user();
        $progress = Progress::where('user_id', $user->id)
            ->whereHas('lesson', function($query) use ($finalType) {
                $query->where('type_lesson_id', $finalType);
            })
            ->with('lesson')
            ->get();
        return ProgressResource::collection($progress) ;
    }

    public function findNextLesson(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Пользователь не аутентифицирован'], 401);
        }

        $nextLesson = Progress::where('user_id', $user->id)
            ->where('lesson_id', '>', $request->lesson_id)
            ->whereHas('lesson', function ($query) use ($request) {
                $query->where('type_lesson_id', $request->type_lesson_id);
            })
            ->with('lesson')
            ->first();

        if ($nextLesson) {
            return response()->json($nextLesson);
        } else {
            return response()->json(['message' => 'Следующий урок не найден'], 404);
        }
    }

    public function doneLesson(Request $request){
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Пользователь не аутентифицирован'], 401);
        }

        $lesson = Progress::where('user_id', $user->id)
            ->where('lesson_id', $request->lesson_id)
            ->first();

        if ($lesson) {
          $lesson->status_id=2;
          $lesson->save();
          return response()->json(['message' => 'Урок пройден']);
        }else{
            return response()->json($request->lesson_id);
        }
    }

    public function checkProgress(){
        $user=auth()->user();

        // Выборка по теории
        $countLessonsTheory=Lesson::where('type_lesson_id',1)->count();
        $countTheoryDone= Progress::where('user_id', $user->id)
            ->where('status_id',2)
            ->whereHas('lesson', function ($query) {
                $query->where('type_lesson_id',1);
            })
            ->count();

        // Выборка по практике
        $countLessonsPractic=Lesson::where('type_lesson_id',2)->count();
        $countPracticDone= Progress::where('user_id', $user->id)
            ->where('status_id',2)
            ->whereHas('lesson', function ($query) {
                $query->where('type_lesson_id',2);
            })
            ->count();

        return response()->json([
            'countDoneTheory'=>$countTheoryDone,
            'countTheory'=>$countLessonsTheory,
            'countDonePractic'=>$countPracticDone,
            'countPractic'=>$countLessonsPractic,
        ]);
    }

}
