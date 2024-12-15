<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokalbis extends Model
{
    use HasFactory;

    protected $table = 'pokalbis';

    protected $fillable = [
        'pradzios_laikas',
        'naudotojo_id',
        'admin_id',
        'created_at',
        'updated_at'
    ];

    public function zinutes()
    {
        return $this->hasMany(Zinute::class, 'pokalbio_id');
    }
    // In the Pokalbis model
public function users()
{
    return $this->belongsToMany(User::class);
}
}
