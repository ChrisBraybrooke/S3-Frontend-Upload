<?php

namespace ChrisBraybrooke\Helpers\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WasCreatedBy
{
    /**
     * The model that should be used for the created by relation.
     *
     * @return string
     */
    private static function createdByModel()
    {
        return User::class;
    }

    /**
     * The user who created this object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(static::createdByModel(), 'created_by', 'id');
    }
}