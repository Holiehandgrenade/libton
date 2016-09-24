<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function libs()
    {
        return $this->hasMany(Lib::class);
    }

    public function write($lib)
    {
        return $this->libs()->save($lib);
    }

    public function play(Lib $lib)
    {
        $play = new Play([
            'user_id' => $this->id,
            'lib_id' => $lib->id,
        ]);

        $play->save();
    }
}
