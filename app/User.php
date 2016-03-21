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

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    protected $access_levels = [
        'ADMIN'         => 999,
        'TEACHER'       => 1,
        'USER'          => 0,
    ];

    public function archives()
    {
        return $this->hasMany('App\Archive');
    }
    
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }
    
    public function isInGroup($id)
    {
        return $this->groups()->where('id', $id)->exists();
    }
    
    public function isAdmin()
    {
        return $this->access_level == 'ADMIN';
    }
    
    public function isTeacher()
    {
        return $this->access_level == 'TEACHER';
    }
    
    public function hasPermission($role)
    {
        $role = strtoupper(trim($role));
        if(array_key_exists($role, $this->access_levels))
        {
            return $this->powerLevel >= $this->access_levels[$role];
        }
        
        return false;
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
