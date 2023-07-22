<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;
    protected $table = 'mensagens'; // Verifique o nome da tabela aqui
    protected $fillable = ['nome', 'mensagem'];
}
