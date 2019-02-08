<?php

namespace App\Http\Controllers;

use App\Access;
use App\Http\Requests\StoreAccessFormRequest;
use App\Http\Requests\UpdateAccessFormRequest;

/**
 * Class AccessController
 * @package App\Http\Controllers
 */
class AccessController extends Controller
{
    protected $redirect = 'access.index';

    /**
     * Display a listing of \App\Access.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('access.index')->with([
           'accesses' => Access::get()
        ]);
    }

    /**
     * Show the form for creating a new \App\Access.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('access.create');
    }

    /**
     * Store a newly created \App\Access in storage.
     *
     * @param  \App\Http\Requests\StoreAccessFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAccessFormRequest $request)
    {
        Access::create($request->all());
        \Alert::success(trans('alerts.save_success'))->flash();

        return redirect(route($this->redirect));
    }

    /**
     * Show the form for editing \App\Access.
     *
     * @param  \App\Access  $access
     * by model-key-binding
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Access $access)
    {
        return view('access.show_and_edit')->with([
            'access' => $access
        ]);
    }

    /**
     * Update the specified \App\Access in Database.
     *
     * @param  \App\Http\Requests\UpdateAccessFormRequest $request
     * @param  \App\Access  $access
     * by model-key-binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAccessFormRequest $request, Access $access)
    {
        $access->update($request->all());
        \Alert::success(trans('alerts.save_success'))->flash();

        return redirect(route($this->redirect));
    }

    /**
     * Remove the specified \App\Access from Database.
     *
     * @param  \App\Access  $access
     * by model-key-binding
     * @throws \Exception
     * my throws an Exception if the Reason not Exists,
     * not validated, because is only available for Admins
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Access $access)
    {
        #Todo check if this Access is in use
        $access->delete();
        \Alert::success(trans('alerts.delete_success'))->flash();

        return redirect(route($this->redirect));
    }
}
