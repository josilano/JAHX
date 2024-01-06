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
        'name', 'email', 'password', 'cargo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function listarUsuarioPaginado($qtd_por_pag)
    {
        try
        {
            $usuarios = User::paginate($qtd_por_pag);
            if ($usuarios == null) return null;
            
            return $usuarios;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public static function getUsuarioPorNome($slug)
    {
        try
        {
            $usuario = User::where('name', 'like', '%'.$slug.'%')->first();
            
            if ($usuario == null) return null;

            return $usuario;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
        //return $this->hasMany('App\Permission');
    }

    public function vendas()
    {
        return $this->hasMany('App\Venda', 'id_usuario');
    }

    public function compras()
    {
        return $this->hasMany('App\Compra', 'id_usuario');
    }

    public function prevendas()
    {
        return $this->hasMany('App\PreVenda', 'id_usuario');
    }

    public function caixas()
    {
        return $this->hasMany('App\Caixa', 'usuario_id');
    }
}
