<?php

namespace ChrisBraybrooke\S3DirectUpload\Http\Controllers\Api;

use ChrisBraybrooke\S3DirectUpload\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AWSFileUploadDeleteController extends Controller
{
    public function __construct()
    {
        if ((config('s3directupload.allow_public') && request()->bearerToken()) || !config('s3directupload.allow_public')) {
            $this->middleware('auth:api');
        } elseif (config('s3directupload.allow_public')) {
            $this->middleware('signed');
        }
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $fileId)
    {
        $file = config('s3directupload.file_model')::findOrFail($fileId);

        if (auth()->check()) {
            $this->authorize('delete', $file);
        }

        $file->delete();
        return response()->deletedOk();
    }
}
