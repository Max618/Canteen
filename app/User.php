<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

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

    // UM USER TEM UM ALUNO
    /*public function aluno()
    {
        return $this->hasOne('App\Aluno');
    }*/

    // UM USER TEM MUITOS RELACIONAMENTOS
    public function relacionamentos()
    {
        return $this->hasMany('App\Relacionamento');
    }

    // UM User TEM MUITOS PEDIDOS
    public function pedidos()
    {
        return $this->hasMany('App\Pedido','user_id');
    }

    public function filhos()
    {
        return $this->belongsToMany('App\Aluno', 'relacionamentos');
    }
}
