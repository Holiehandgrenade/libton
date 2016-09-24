<?php

namespace App\Policies;

use App\Lib;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LibPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Lib $lib)
    {
        return $user->id == $lib->user_id;
    }

    public function destroy(User $user, Lib $lib)
    {
        return $user->id == $lib->user_id;
    }
}
