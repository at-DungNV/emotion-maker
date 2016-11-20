<?php


Route::get('emotion/index', [
    'as' => 'emotion.index', 'uses' => 'PHP2\EmotionMaker\EmotionController@index'
]);

Route::get('emotion/index1', [
    'as' => 'emotion.index1', 'uses' => 'PHP2\EmotionMaker\EmotionController@index1'
]);


Route::post('emotion/submit', [
    'as' => 'emotion.submit', 'uses' => 'PHP2\EmotionMaker\EmotionController@submit'
]);

Route::get('emotion/show/{emotion?}', [
    'as' => 'emotion.show', 'uses' => 'PHP2\EmotionMaker\EmotionController@show'
]);


Route::get('emotion/emotion', [
    'as' => 'emotion.emotion', 'uses' => 'PHP2\EmotionMaker\EmotionController@emotion'
]);
