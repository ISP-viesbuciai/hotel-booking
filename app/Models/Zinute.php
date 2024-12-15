<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zinute extends Model
{
    use HasFactory;

    protected $table = 'zinute';
    public $timestamps = false;


    protected $fillable = [
        'pokalbio_id',
        'siuntejo_id',
        'gavejo_id',
        'tekstas',
        'laikas'
    ];

    public function pokalbis()
    {
        return $this->belongsTo(Pokalbis::class, 'pokalbio_id');
    }
}
