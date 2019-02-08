<?php

namespace App\Observers;

use App\User;

#use App\Mail\UserCreatedMail;
#use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
#use Illuminate\Support\Facades\Password;

class UserObserver
{
    #use SendsPasswordResetEmails;

    public function created(User $user)
    {
        # \Mail::to($user)->queue((new UserCreatedMail($user))->onQueue('email'));
        $user->sendResetLinkEmail($user->email);
        return true;
    }

    public function saving(User $user)
    {
        # set language for localization / used by localization middleware via session
        if (!session()->has('localization')) {
            session(['localization' => $user->language]);
        }
        \App::setLocale(session('localization'));
        return true;
    }

    public function deleting(User $user)
    {
        # clears up pivot table
        $user->accesses()->detach();

        # delete related periods
        $user->periods()->delete();

        return true;
    }
}
