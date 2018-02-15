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
        'title',
        'description',
        'status_id',
        'created_by_id',
        'updated_by_id'
    ];

    protected $guarded = [
        'ticket_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    #endregion

    #region Relationships
    /***
     * Returns Query Object of Category that owns Ticket.
     * Lazy loads Category Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /***
     * Returns Query Object for comments belonging to this ticket.
     * Lazy loads Collection of Comments.
     *
     * @return $this
     */
    public function comments() {
        return $this->morphMany(Comment::class,'commentable', 'parent_type', 'parent_id')->orderBy('created_at', 'ASC');
    }

    /***
     * Returns Query Object of User that created the Ticket.
     * Lazy loads User Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function created_by() {
        return $this->belongsTo(User::class,'created_by_id');
    }

    /***
     * Returns Query Object of Priority that owns Ticket.
     * Lazy loads Priority Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority() {
        return $this->belongsTo(Priority::class);
    }

    /***
     * Returns Query Object of Status that owns Ticket.
     * Lazy loads Status Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status() {
        return $this->belongsTo(Status::class);
    }

    /***
     * Returns Query Object of User that last updated the Ticket.
     * Lazy loads User Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updated_by() {
        return $this->belongsTo(User::class, 'updated_by_id');
    }
    #endregion

    #region Public Methods
    /***
     * Overloaded delete method.
     * Deletes child comments before deleting self.
     *
     * @return bool|null
     */
    public function delete()
    {
        $this->comments()->delete();
        return parent::delete();
    }
    #endregion
}
