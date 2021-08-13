<?php

namespace ChrisBraybrooke\Helpers\Traits;

use Illuminate\Support\Str;

trait HasFirstLastName
{
    /**
     * Get just the first word of the "name" attribute.
     *
     * @return string
     */
    public function getFirstNameAttribute()
    {
        return Str::before($this->name, ' ');
    }

    /**
     * Get just the last word(s) of the "name" attribute.
     *
     * @return string
     */
    public function getLastNameAttribute()
    {
        return Str::after($this->name, ' ');
    }
}