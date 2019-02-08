<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Reason
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reason query()
 * @mixin \Eloquent
 */
class Reason extends Model
{
    protected $fillable = [
        'title',
        'description',
        'color',
        'hex_color',
        'has_to_confirm'
    ];

    /**
     * Cast has_to_confirm to 0/false when it is null and stored in DB
     * Mutator
     *
     * @param  string $value
     * @return void
     */
    public function setHasToConfirmAttribute($value)
    {
        $this->attributes['has_to_confirm'] = $value ?? 0;

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periods()
    {
        return $this->hasMany(Period::class)->orderBy('reason_id')->orderBy('start');
    }

    /**
     * @return Boolean
     */
    public function hasNotPeriods()
    {
        return $this->periods()->count() == 0;
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeToConfirm($query)
    {
        return $query->where('has_to_confirm', 1);
    }


}
