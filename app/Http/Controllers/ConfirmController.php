<?php

namespace App\Http\Controllers;

use App\Period;
use App\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ConfirmController extends Controller
{
    /**
     * @var string
     */
    protected $timezone = 'Europe/Berlin';

    /**
     * save all periods that are confirmed
     * and all periods that has to confirm in session
     * an show them in view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        session([
            'periods_unconfirmed' => Period::with('user')->byHasToConfirm()->byNotConfirmed()->get() ?? [],  #TODO scope confirmed and start
            'periods_confirmed' => Period::with('user')->byHasToConfirm()->byConfirmed()->byFuture()->get() ?? [] #TODO scope confirmed and start
        ]);
        $reasons = Reason::get();

        return view('confirm.index')->with([
            'reasons' => $reasons,
        ]);
    }

    /**
     * change the confirmation for Periods in Database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        #todo on update email notification
        #todo check for updating session
        $success = false;

        if ((session('periods_unconfirmed') ?? false) && $request->periods_new_confirmed ?? false) {
            foreach (array_intersect(session('periods_unconfirmed')->pluck('id')->toArray(), $request->periods_new_confirmed) as $period_id) {
                $period = Period::find($period_id);
                if ($period ?? false) {
                    if ($period->reason->has_to_confirm) {
                        $period->confirmed = Carbon::now()->timezone($this->timezone);
                        $success = $period->save();
                    }
                }
            }
        }
        if (session('periods_confirmed') ?? false) {
            foreach (array_diff(session('periods_confirmed')->pluck('id')->toArray(), $request->periods_confirmed ?? []) as $period_id) {
                $period = Period::find($period_id);
                if ($period ?? false) {
                    if ($period->reason->has_to_confirm) {
                        $period->confirmed = null;
                        $success = $period->save();
                    }
                }
            }
        }

        if ($success) {
            \Alert::success(trans('alerts.save_success'))->flash();
        } else {
            \Alert::warning(trans('alerts.save_failed'))->flash();
        }

        return redirect()->route('confirm.index');
    }
}
