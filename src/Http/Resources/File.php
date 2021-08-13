<?php

namespace ChrisBraybrooke\S3DirectUpload\Http\Resources;

use ChrisBraybrooke\S3DirectUpload\Models\File as FileModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class File extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'disk' => $this->disk,
            'path' => $this->path,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'signed_delete_url' => URL::temporarySignedRoute('file.aws.delete', now()->addMinutes(30), $this->resource),
            // 'created_by' => new User($this->whenLoaded('createdBy')),
            // 'pivot' => $this->whenPivotLoaded('fileables', function () {
            //    return [
            //         'key' => $this->pivot->key,
            //         'key_label' => FileModel::keyTypes()[$this->pivot->key] ?? null
            //    ];
            // }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
