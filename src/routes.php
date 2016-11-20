<?php


Route::get('dungnv/{timezone?}', 'dungnv\timezones\TimezonesController@index');

Route::get('api/demo', 'dungnv\timezones\TimezonesController@demo');

Route::get('emotion/index', [
    'as' => 'emotion.index', 'uses' => 'dungnv\timezones\EmotionController@index'
]);

Route::get('emotion/index1', [
    'as' => 'emotion.index1', 'uses' => 'dungnv\timezones\EmotionController@index1'
]);


Route::post('emotion/submit', [
    'as' => 'emotion.submit', 'uses' => 'dungnv\timezones\EmotionController@submit'
]);

Route::get('emotion/show/{emotion?}', [
    'as' => 'emotion.show', 'uses' => 'dungnv\timezones\EmotionController@show'
]);


Route::get('emotion/emotion', [
    'as' => 'emotion.emotion', 'uses' => 'dungnv\timezones\EmotionController@emotion'
]);
