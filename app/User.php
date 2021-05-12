<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Webpatser\Uuid\Uuid;
use Laravel\Passport\HasApiTokens;
use Auth;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @param array
     */
    protected $fillable = [
        'firstName', 'lastName', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @param array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Auto generates the `uuid` field for the new User.
     *
     * @param options List of options.
     *
     * @return User
     */
    public function save(array $options = [])
    {   
        $this->photo = "default_avatar.png";
        $this->branch = 0;
        $this->role = 0;
        $this->parent_id = 0;
        $this->employeeId = Uuid::generate(4);
        return parent::save($options);
    }

    /**
     * Find user by id.
     * 
     * @return User
     */
    public function findById($user_id)
    {
        return self::where('id', '=', $user_id)->get();
    }
}
