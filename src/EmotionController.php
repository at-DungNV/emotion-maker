<?php

namespace PHP2\EmotionMaker;

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
      return view('php2::view', compact('img'));
    }

    public function index()
    {
        return view('php2::view');
    }
    public function index1()
    {
        return view('php2::view1');
    }


    public function emotion()
    {
        // return view('php2::view');
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
