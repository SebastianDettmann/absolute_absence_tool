<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReasonFormRequest;
use App\Http\Requests\UpdateReasonFormRequest;
use App\Reason;

class ReasonController extends Controller
{
    /**
     * @var string
     */
    protected $redirect = 'reason.index';

    /**
     * Display a listing of \App\Reason.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $reasons = Reason::get();

        return view('reason.index')->with([
            'reasons' => $reasons
        ]);
    }

    /**
     * Show the form for creating a new \App\Reason.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('reason.create');
    }

    /**
     * Store a newly created \App\Reason in Database.
     *
     * @param  \App\Http\Requests\StoreReasonFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreReasonFormRequest $request)
    {
        Reason::create($request->all());
        \Alert::success(trans('alerts.save_success'))->flash();

        return redirect(route($this->redirect));
    }

     /**
      * Show the form for editing \App\Reason.
      * used to as show view
     *
     * @param  \App\Reason  $reason
      * by model-key-binding
      * @return \Illuminate\Contracts\View\View
     */
    public function edit(Reason $reason)
    {
        return view('reason.show_and_edit')->with([
            'reason' => $reason
        ]);
    }

    /**
     * Update the specified \App\Reason in Database.
     *
     * @param  \App\Http\Requests\UpdateReasonFormRequest $request
     * @param  \App\Reason  $reason
     * by model-key-binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateReasonFormRequest $request, Reason $reason)
    {
        $reason->has_to_confirm = $request->has_to_confirm;
        $reason->update($request->all());
        \Alert::success(trans('alerts.save_success'))->flash();

        return redirect(route($this->redirect));
    }

    /**
     * Remove the specified \App\Reason From Database.
     *
     * @param  \App\Reason  $reason
     * by model-key-binding
     * @throws \Exception
     * my throws an Exception if the Reason not Exists,
     * not validated, because is only available for Admins
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reason $reason)
    {
        $success = false;

        if ($reason->hasNotPeriods()) {
            $success = $reason->delete();
        }

        if ($success) {
            \Alert::success(trans('alerts.delete_success'))->flash();
        } else {
            \Alert::warning(trans('alerts.delete_failed'))->flash();
        }

        return redirect(route($this->redirect));
    }
}
