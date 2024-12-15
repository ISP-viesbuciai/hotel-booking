<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kambarys extends Model
{
    use HasFactory;

    protected $table = 'kambarys';
    protected $primaryKey = 'kambario_id';
    public $timestamps = false; // Since your table doesn't have created_at and updated_at

    protected $fillable = [
        'kambario_nr',
        'tipas',
        'capacity',
        'kaina_nakciai',
        'available',
        'aukstas',
        'vaizdas_i_jura'
    ];
}
