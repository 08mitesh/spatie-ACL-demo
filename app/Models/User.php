<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Traits\LogsActivity;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'phone'
    ];

    protected static $logAttributes = ['name',
    'email',
    'password',
    'photo',
    'phone'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $appends = ['all_permissions','can'];

    // public function getAllPermissionsAttribute()
    // {
    //     return $this->getAllPermissions();
    // }

    // public function getAllPermissions() {
    //     $permissions = [];
    //       foreach (Permission::all() as $permission) {
    //         if (Auth::user()->can($permission->name)) {
    //           $permissions[] = $permission->name;
    //         }
    //       }
          
    //       return $permissions;
    //   }
}
