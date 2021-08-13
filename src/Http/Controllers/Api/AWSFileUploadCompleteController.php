<?php

namespace ChrisBraybrooke\S3DirectUpload\Http\Controllers\Api;

use ChrisBraybrooke\S3DirectUpload\Http\Controllers\Controller;
use ChrisBraybrooke\S3DirectUpload\Http\Requests\AWSFileUploadCompleteRequest;
use ChrisBraybrooke\S3DirectUpload\Http\Resources\File as FileResource;

class AWSFileUploadCompleteController extends Controller
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
    public function __invoke(AWSFileUploadCompleteRequest $request)
    {
        $resource = config('s3directupload.file_resource');
        return new $resource(
            config('s3directupload.file_model')::create(
                $request->validated()
            )
        );
    }
}
