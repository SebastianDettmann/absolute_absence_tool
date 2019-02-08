<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeriodFormRequest;
use App\Period;
use App\Reason;
use Carbon\Carbon;

class PeriodController extends Controller
{
    /**
     * @var string
     */
    protected $redirect = 'period.index'; #todo check for usability
    /**
     * @var string
     */
    protected $timezone = 'Europe/Berlin';
    /**
     * @var null|static
     */
    protected $current_date = null;
    /**
     * @var $this |null
     */
    protected $calendar = null;
    /**
     * @var array
     */
    protected $calendar_options = [ //set fullcalendar options
        'firstDay' => 1, //Week starts with Monday
        'header' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'month,basicWeek',
        ],
        'navLinks' => true, // can click day/week names to navigate views
        'editable' => true,
        'selectable' => true,
        'eventLimit' => true, // allow "more" link when too many events
        'locale' => 'de',
        'contentHeight' => 500,
    ];

    /**
     * PeriodController constructor.
     */
    public function __construct()
    {
        $this->current_date = Carbon::now();
        $this->calendar = \Calendar::setOptions($this->calendar_options);
    }

    /**
     * Display a listing \App\Period by user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        #todo check for use ajax

        $periods_year_now_past = [];
        $periods_year_now_current = [];
        $periods_year_now_future = [];
        $current_year = $this->current_date->year;
        $calendar_periods = [];
        $reasons = Reason::get();
        $periods = auth()->user()->periods->sortBy('start');

        foreach ($periods as $period) {
            if ($period->start->year == $current_year || $period->end->year == $current_year) {
                if ($this->current_date->between($period->start, $period->end)) {
                    $periods_year_now_current[] = $period;
                } elseif ($this->current_date->gt($period->end)) {
                    $periods_year_now_past[] = $period;
                } else {
                    $periods_year_now_future[] = $period;
                }
            }
            # add periods to Calendar
            $calendar_periods[] = \Calendar::event(
                $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText(), //event title
                true, //full day event?
                $period->start, //start time (you can also use Carbon instead of DateTime)
                $period->end->addDay(), //end time (you can also use Carbon instead of DateTime) !!!nessesery to add a day!!!
                $period->id, //optionally, you can specify an event ID
                [
                    'color' => $period->pendingColor(),
                    'textColor' => '#000000']
            );
        }

        $this->calendar->addEvents($calendar_periods);

        return view('period.index')->with([
            'periods_year_now_future' => $periods_year_now_future,
            'periods_year_now_current' => $periods_year_now_current,
            'periods_year_now_past' => $periods_year_now_past,
            'reasons' => $reasons,
            'calendar' => $this->calendar,
        ]);
    }

    /**
     * Display a listing of all \App\Period.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexAll()
    {
        $periods = Period::with('reason')->get();
        $reasons = Reason::get();
        $calendar_periods = [];

        foreach ($periods as $period) {
            # add periods to Calendar
            $calendar_periods[] = \Calendar::event(
                $period->pendingUser() . ' : ' . $period->reason->title . ' ' . $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y'), //event title
                true, //full day event?
                $period->start, //start time (you can also use Carbon instead of DateTime)
                $period->end->addDay(), //end time (you can also use Carbon instead of DateTime) !!!nessesery to add a day!!!
                $period->id, //optionally, you can specify an event ID
                [
                    'color' => $period->pendingColor(),
                    'textColor' => '#000000']
            );
        }

        $this->calendar->addEvents($calendar_periods);

        return view('period.indexall')->with([
            'reasons' => $reasons,
            'calendar' => $this->calendar,
        ]);
    }

    /**
     * Store a newly created \App\Period in Database.
     *
     * @param  \App\Http\Requests\StorePeriodFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePeriodFormRequest $request)
    {
        # TODO check for using mutators
        $data = [
            'start' => Carbon::createFromFormat('d.m.Y', $request->start),
            'end' => Carbon::createFromFormat('d.m.Y', $request->end),
            'comment' => $request->comment,
            'reason_id' => $request->reason_id,
        ];
        $period = auth()->user()->periods()->create($data);

        if ($period) {
            \Alert::success(trans('alerts.save_success'))->flash();
        } else {
            \Alert::warning(trans('alerts.save_failed'))->flash();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified \App\Period from Database.
     *
     * @param  \App\Period  $period
     * by model-key-binding
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * rendered as 404
     * @throws \Exception
     * my throws an Exception if the Reason not Exists,
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        $this->authorize('access', $period);
        $success = false;

        if ($period->start->gt($this->current_date)) {
            $success = $period->delete();
        }

        if ($success) {
            \Alert::success(trans('alerts.delete_success'))->flash();
        } else {
            \Alert::warning(trans('alerts.delete_failed'))->flash();
        }

        return redirect()->back();
    }
}
