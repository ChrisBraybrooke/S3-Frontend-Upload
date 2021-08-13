<?php

namespace ChrisBraybrooke\Helpers\Traits;

trait CheckHasJoin
{
    /**
     * Determin if a join has already happened.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string $table
     * @return boolean
     */
    public static function isJoined($query, $table)
    {
        return collect($query->getQuery()->joins)->pluck('table')->contains($table);
    }
}