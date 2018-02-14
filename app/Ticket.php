<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    //
    #region Attributes
    protected $table = 'tickets';

    protected $fillable = [
        'category_id',
        'priority_id',
        'ticket_id',
        'title',
        'description',
        'status_id',
        'created_by_id',
        'updated_by_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    #endregion

    #region Relationships
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->morphMany(Comment::class,'commentable', 'parent_type', 'parent_id')->orderBy('created_at', 'ASC');
    }

    public function created_by() {
        return $this->belongsTo(User::class,'created_by_id');
    }

    public function priority() {
        return $this->belongsTo(Priority::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function updated_by() {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    #endregion
}
