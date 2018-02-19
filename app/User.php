<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    #region Attributes
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'is_admin'
    ];

    protected $guarded = [
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    #endregion

    #region Relationships

    /***
     * Returns Query Object for all tickets created by User.
     * Lazy loads Collection of Ticket Objects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submitted_tickets() {
        return $this->hasMany(Ticket::class,'created_by_id');
    }

    /***
     * Returns Query Object for all tickets updated by User.
     * Lazy loads Collection of Ticket Objects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function updated_tickets() {
        return $this->hasMany(Ticket::class, 'updated_by_id');
    }
    #endrelationships

    #region Public Methods

    /***
     * encrypts andd sets the users password attribute
     * @param string $new_password
     */
    public function setPassword(string $new_password){
        $this->password = bcrypt($new_password);
    }

    /***
     * Needed for JWT package.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /***
     * Needed for JWT package.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    #endregion

}
