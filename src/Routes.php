<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['api'], 'prefix'=>'api' ], function () {
    Route::get('huebridge/{bridge}/lights', 'MetaverseSystems\HuePHPBackend\Controllers\HueLightController@index');
    Route::get('huebridge/{bridge}/groups', 'MetaverseSystems\HuePHPBackend\Controllers\HueGroupController@index');
    Route::post('huebridge/{bridge}/groups/{group}', 'MetaverseSystems\HuePHPBackend\Controllers\HueGroupController@update');
    Route::get('huebridge', 'MetaverseSystems\HuePHPBackend\Controllers\HueBridgeController@index');
    Route::get('huebridge/scan', 'MetaverseSystems\HuePHPBackend\Controllers\HueBridgeController@scan');
    Route::post('huebridge', 'MetaverseSystems\HuePHPBackend\Controllers\HueBridgeController@store');
});
