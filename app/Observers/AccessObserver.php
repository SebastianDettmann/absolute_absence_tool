<?php

namespace App\Observers;

use App\Access;

class AccessObserver
{
    public function saving(Access $access)
    {
        # create slug
        $access->slug = str_slug($access->title, '_');

        return true;
    }

    public function deleting(Access $access)
    {
        # clears up pivot table
        $access->users()->detach();

        # clears up cached Access keys for users (all users)
        $key = 'accesses_' . $access->slug;
        !cache()->has($key) ?: cache()->forget($key);

        return true;
    }
}
