<?php


Route::get('emotion/index', [
    'as' => 'emotion.index', 'uses' => 'php2\emotion-maker\EmotionController@index'
]);

Route::get('emotion/index1', [
    'as' => 'emotion.index1', 'uses' => 'php2\emotion-maker\EmotionController@index1'
]);


Route::post('emotion/submit', [
    'as' => 'emotion.submit', 'uses' => 'php2\emotion-maker\EmotionController@submit'
]);

Route::get('emotion/show/{emotion?}', [
    'as' => 'emotion.show', 'uses' => 'php2\emotion-maker\EmotionController@show'
]);


Route::get('emotion/emotion', [
    'as' => 'emotion.emotion', 'uses' => 'php2\emotion-maker\EmotionController@emotion'
]);
