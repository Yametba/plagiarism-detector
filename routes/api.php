<?php

use App\Http\Controllers\Admin\AnalysisItemController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Documents
    Route::post('documents/media', 'DocumentsApiController@storeMedia')->name('documents.storeMedia');
    Route::apiResource('documents', 'DocumentsApiController');

    // Settings
    Route::apiResource('settings', 'SettingsApiController');

    // Workspace
    Route::post('workspaces/media', 'WorkspaceApiController@storeMedia')->name('workspaces.storeMedia');
    Route::apiResource('workspaces', 'WorkspaceApiController');

    // Folder
    Route::post('folders/media', 'FolderApiController@storeMedia')->name('folders.storeMedia');
    Route::apiResource('folders', 'FolderApiController');

    // Analysis Item
    Route::apiResource('analysis-items', 'AnalysisItemApiController');

    Route::post('/update-analysis-result', [AnalysisItemController::class, '']);
});
