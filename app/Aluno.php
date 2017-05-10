<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = [
        'turma','user_id'
    ];

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    // UM ALUNO TEM UM RELACIONAMENTO
    public function relacionamento()
    {
        return $this->hasOne('App\Relacionamento');
    }

    // UM ALUNO VEM DE UM USER
    public function user()
    {
        return $this->hasOne('App\User','id');
    }

    // UM ALUNO TEM MUITOS PEDIDOS
    public function pedidos()
    {
        return $this->hasMany('App\Pedido');
    }


}
