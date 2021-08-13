<?php

/*
|--------------------------------------------------------------------------
| s3-direct-upload API Routes
|--------------------------------------------------------------------------
|
| These are the api routes for s3-direct-upload, the 'api' middleware has already
| been applied and the controllers are mapped to the Api folder within the
| Http/Controller directory.
|
*/

// Files Upload URL
Route::post('files/upload-url', 'AWSFileUploadRouteController')->name('file.aws.url');
Route::post('files/complete', 'AWSFileUploadCompleteController')->name('file.aws.complete');
Route::delete('files/{file}', 'AWSFileUploadDeleteController')->name('file.aws.delete');