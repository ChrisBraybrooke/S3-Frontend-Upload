<?php

namespace ChrisBraybrooke\Helpers\Models;

use Illuminate\Database\Eloquent\Model as Model;
use ChrisBraybrooke\Helpers\Traits\HasUUID;

class BaseModel extends Model
{
    use HasUUID;

    /**
     * Whether the ID collumn in auto incrementing.
     *
     * @return boolean
     */
    public $incrementing = false;

    /**
     * What the ID collumn key type is.
     *
     * @return string
     */
    protected $keyType = 'string';
}
