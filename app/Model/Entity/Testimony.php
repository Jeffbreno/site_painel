<?php

namespace App\Model\Entity;

use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    //TABELA NO BANCO DE DADOS
    protected $table = 'depoimentos';
    //CAMPOS USADOS NA TABELA DE DADOS
    protected $fillable = ['nome', 'mensagem', 'data'];
    public $timestamps = false;
    
    /**
     * Método responsável por retornar busca por ID de depoimentos
     *
     */
    public static function getById(int $id): mixed
    {
        return self::find($id);
    }

}
