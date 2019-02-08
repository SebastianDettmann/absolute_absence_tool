<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Period
 *
 * @property-read \App\Reason $reason
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Period newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Period newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Period query()
 * @mixin \Eloquent
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Period byConfirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Period byNotConfirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Period byOld()
 */
class Period extends Model
{
    /**
     * @var array
     * all attributes for mass assignment
     */
    protected $fillable = [
       'start',
       'end',
       'comment',
        'reason_id',
    ];

    /**
     * @var array
     * all Date attributes /cast to date / Carbon
     */
    protected $dates = [
       'start',
       'end',
       'confirmed'
    ];

    /**
     * @var array
     * all eager loaded models
     */
    protected $with = ['reason'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reason()
    {
       return $this->belongsTo(Reason::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
       return $this->belongsTo(User::class);
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeByConfirmed(Builder $query)
    {
        return $query->whereNotNull('confirmed');
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeByNotConfirmed(Builder $query)
    {
        return $query->whereNull('confirmed');
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeByHasToConfirm(Builder $query)
    {
        return $query->whereHas('reason', function ($query) {
            $query->where('has_to_confirm', 1);
        });
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeByFuture(Builder $query)
    {
        return $query->whereDate('start', '>', Carbon::now()->toDateString());
    }

    /**
     * @param Builder $query
     * @param Carbon $date
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeByOlderThen(Builder $query, Carbon $date)
    {
        return $query->whereDate('start', '<',  $date);
    }

    /**
     * @param Builder $query
     * @param Carbon $date
     * @return Builder|\Illuminate\Database\Query\Builder|static
     */
    public function scopeByInMonth(Builder $query, Carbon $date)
    {
        $firstDayOfMonth = $date->startOfMonth()->toDateString();
        $lastDayOfMonth = $date->endOfMonth()->toDateString();

        return $query
            ->whereBetween('start', [$firstDayOfMonth, $lastDayOfMonth])
            ->orWhereBetween('end', [$firstDayOfMonth, $lastDayOfMonth])
            ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                $query->where([
                    ['start', '<', $firstDayOfMonth],
                    ['end', '>', $lastDayOfMonth],
                ]);
            });
    }

    /**
     * @param Builder $query
     * @return Builder|\Illuminate\Database\Query\Builder|static
     */
    public function scopeByCurrentYear(Builder $query)
    {
        $currentYear = Carbon::now()->year;

        #Todo check is it necessary to pay attenchien for periods longer  then 1 year

        return $query
            ->whereYear('start', $currentYear)
            ->orWhereYear('end', $currentYear);
    }

    /**
     * @return bool
     */
    public function pending()
    {
        return (!$this->confirmed && $this->reason->has_to_confirm);
    }

    /**
     * @return mixed|string
     */
    public function pendingColor()
    {
        return $this->pending() ? '#bbbbbb' : $this->reason->hex_color;
    }

    /**
     * @return mixed|string
     */
    public function pendingText()
    {
        return $this->pending() ? $this->reason->title . __(' - unbestätigt') : $this->reason->title;
    }

    /**
     * @return mixed|string
     */
    public function pendingUser()
    {
        return $this->pending() ? $this->user->fullName() . __(' - unbestätigt') : $this->user->fullName();
    }
}
