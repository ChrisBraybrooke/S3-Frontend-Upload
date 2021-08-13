<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

return [
    'user_model' => User::class,

    'permission_model' => Permission::class,

    'role_model' => Role::class
];