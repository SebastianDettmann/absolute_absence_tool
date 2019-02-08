<?php

namespace App\Observers;

use App\Period;

class PeriodObserver
{
    public function created(Period $period)
    {
        #todo has to confirm email / !$period->pending() ? : email an verteiler
        return true;
    }

    public function updating(Period $period)
    {
        #todo if confirmed email / if ($period->isDirty('is_confirmed')) {$period->pending() ?  email $period->user confirmed : email $period->user unconfirmed}
        return true;
    }
}
