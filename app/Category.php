<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
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
