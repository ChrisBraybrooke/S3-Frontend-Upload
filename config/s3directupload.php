<?php

use ChrisBraybrooke\S3DirectUpload\Http\Resources\File as FileResource;
use ChrisBraybrooke\S3DirectUpload\Models\File;

return [

    /*
    |--------------------------------------------------------------------------
    | Ignore Migrations?
    |--------------------------------------------------------------------------
    |
    | This option determines whether laravel should ignore the package migrations
    | when running `php artisan:migrate`. If you wish to customise the migrations,
    | you can run `php artisan vendor:publish --tag=s3-direct-upload-migrations` and
    | then set this option to true.
    |
    */

    'ignore_migrations' => false,

    /*
    |--------------------------------------------------------------------------
    | Upload Disk
    |--------------------------------------------------------------------------
    |
    | The disk to use for file upload, this should be a value defined in your
    | `filesystems.php` config file.
    |
    */

    'upload_disk' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Allow Public
    |--------------------------------------------------------------------------
    |
    | Should we allow public uploads?
    |
    */

    'allow_public' => false,

    /*
    |--------------------------------------------------------------------------
    | File Model & Resource
    |--------------------------------------------------------------------------
    |
    | The file model and resource to use, when creating files that have been uploaded.
    |
    */

    'file_model' => File::class,

    'file_resource' => FileResource::class
];