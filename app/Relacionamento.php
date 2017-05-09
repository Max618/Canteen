<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relacionamento extends Model
{
    protected $fillable = [
        'aluno_id', 'user_id'
    ];
    // UM RELACIONAMENTO VEM DE UM ALUNO
    public function aluno()
    {
        return $this->belongsTo('App\Aluno');
    }

    // UM RELACIONAMENTO VEM DE MUITOS USERS
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
