<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];
    
    protected $access_levels = [
        'ADMIN'         => 999,
        'TEACHER'       => 1,
        'USER'          => 0,
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function archives()
    {
        return $this->hasMany('App\Archive');
    }
    
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }
    
    public function isAdmin()
    {
        return $this->access_level == 'ADMIN';
    }
    
    public function isTeacher()
    {
        return $this->access_level == 'TEACHER';
    }
    
    public function getPowerLevelAttribute()
    {
        return $this->access_levels[$this->access_level];
    }
    
    public function canAccessAdminPanel()
    {
        return $this->powerLevel >= 1;
    }
    
    public function canAccessAjax()
    {
        return $this->canAccessAdminPanel();
    }

}
