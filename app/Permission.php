<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
    	'user_id',
    	'funcao',
    	'cod_funcao'
    ];

    public static function novaPermission()
    {
        return new Permission();
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_id');
        //return $this->belongsTo('App\User', 'user_id');
    }
}
