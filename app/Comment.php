<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
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

    /**
     * Morphable method to support polymorphic relationships.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable() {
        return $this->morphTo();
    }

    /**
     * Return Query of user that created comment.
     * Lazy Loads User Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function created_by() {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    #endregion
}
