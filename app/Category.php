<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    #region Attributes
    protected $table = 'categories';

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
