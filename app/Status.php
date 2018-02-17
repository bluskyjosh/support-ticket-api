<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    //
    #region Attributes
    protected $table = 'statuses';

    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    #endregion

    #region Relationships

    /***
     * Returns Query of tickets belonging to Statuse
     * Lazy loads Collection of tickets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
    #endregion
}
