<?php

namespace DungNV\Timezones;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Song;
use App\Models\Emotion;

class EmotionController extends Controller
{
    public function submit(Request $request)
    {
      $img = $request->imgurl;
      return view('dungnv::view', compact('img'));
    }

    public function index()
    {
        return view('dungnv::view');
    }
    public function index1()
    {
        return view('dungnv::view1');
    }


    public function emotion()
    {
        // return view('dungnv::view');
    }



    public function show($emotion = "happy")
    {
      $emotionID = 1;
      $emotion = Emotion::where('name', '=', $emotion)->first();
      $advice = "abc";
      if(!empty($emotion)) {
        $emotionID = $emotion->id;
        $advice = $emotion->advice;
      }
      $songs = Song::where('emotion_id', '=', $emotionID)->get();
      return response()->json([
          'songs' => $songs,
          'advice' => $advice
      ]);
    }
}
