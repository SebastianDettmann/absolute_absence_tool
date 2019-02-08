<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Access
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Access newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Access newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Access query()
 * @mixin \Eloquent
 */
class Access extends Model
{
    protected $table = 'accesses';

    protected $fillable = [
        'title',
        'slug',
        'url',
        'image'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeByAccess(Builder $query, String $access_slug_title)
    {
        return $query->where('slug', $access_slug_title);
    }
}
