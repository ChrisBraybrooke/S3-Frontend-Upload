<?php

namespace ChrisBraybrooke\S3DirectUpload\Http\Controllers\Api;

use Aws\S3\PostObjectV4;
use Aws\S3\S3Client;
use ChrisBraybrooke\S3DirectUpload\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AWSFileUploadRouteController extends Controller
{
    public function __construct()
    {
        if ((config('s3directupload.allow_public') && request()->bearerToken()) || !config('s3directupload.allow_public')) {
            $this->middleware('auth:api');
        }
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $disk = config('s3directupload.upload_disk');
        $client = new S3Client([
            'version' => 'latest',
            'region' => config("filesystems.disks.{$disk}.key"),
            'credentials' => [
                'key' => config("filesystems.disks.{$disk}.key"),
                'secret' => config("filesystems.disks.{$disk}.secret"),
            ]
        ]);

        // Set some defaults for form input fields
        $formInputs = ['acl' => 'public-read', 'key' => config("filesystems.disks.{$disk}.root") . '/${filename}'];

        // Construct an array of conditions for policy
        $options = [
            ['acl' => 'public-read'],
            ['bucket' => config("filesystems.disks.{$disk}.bucket")],
            ['starts-with', '$key', '']
        ];

        $postObject = new PostObjectV4(
            $client,
            config("filesystems.disks.{$disk}.bucket"),
            $formInputs,
            $options,
            '+2 hours'
        );

        $completeUrl = config('s3directupload.allow_public') ? URL::temporarySignedRoute(
            'file.aws.complete', now()->addMinutes(120)
        ) : route('file.aws.complete');

        return [
            'inputs' => $postObject->getFormInputs(),
            'attributes' => array_merge($postObject->getFormAttributes(), [
                'complete_url' => $completeUrl,
                'path' => config("filesystems.disks.{$disk}.root")
            ])
        ];
    }
}
