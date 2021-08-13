<?php

namespace ChrisBraybrooke\S3DirectUpload\Models;

use ChrisBraybrooke\Helpers\Models\BaseModel;
use ChrisBraybrooke\Helpers\Traits\Responsable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class File extends BaseModel
{
    use HasFactory, Responsable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'disk',
        'path',
        'mime_type',
        'size',
        'name',
        'description',
        'created_by'
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        //
    ];

    /**
     * Which collumns to use for ordering.
     *
     * @return array
     */
    private function responsableOrderByAlias()
    {
        return [
            'id' => 'id',
            'created_at' => 'created_at'
        ];
    }

    /**
     * Which collumns to use for search.
     *
     * @return array
     */
    private function responsableSearch()
    {
        return [
            'id'
        ];
    }

    /**
     * Get the url for this file.
     *
     * @return String
     */
    public function getUrlAttribute(): String
    {
        return Storage::disk($this->disk)->url($this->name);
    }
}
