<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    #region Attributes
    protected $table = 'priorities';

    protected $fillable = [
        'name',
        'description'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    #endregion

    #region Relationships
    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
    #endregion
}
