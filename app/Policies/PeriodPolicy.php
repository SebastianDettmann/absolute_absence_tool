<?php

namespace App\Policies;

use App\User;
use App\Period;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeriodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the period.
     *
     * @param  \App\User  $user
     * @param  \App\Period  $period
     * @return mixed
     */
    public function access(User $user, Period $period)
    {
        return $user->admin ? true : $user->id == $period->user_id;
    }
}
