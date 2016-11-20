<?php

namespace DungNV\Timezones;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

// use Illuminate\Http\Request;

// use App\Http\Requests;

class TimezonesController extends Controller
{
    public function index($timezone = null)
    {
        $current_time = ($timezone)
            ? Carbon::now(str_replace('-', '/', $timezone))
            : Carbon::now();
        return view('dungnv::time', compact('current_time'));
    }

    public function demo()
    {
        return view('dungnv::view');
    }
}
