<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    #region Attributes

    protected $table = 'comments';

    protected $fillable = [
        'created_by_id',
        'comment'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    #endregion


    #region Relationships

    public function commentable() {
        return $this->morphTo();
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    #endregion
}
