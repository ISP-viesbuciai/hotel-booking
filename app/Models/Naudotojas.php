<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Naudotojas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'naudotojas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'kliento_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vardas',
        'pavarde',
        'el_pastas',
        'telefono_nr',
        'adresas',
        'registracijos_data',
        'ar_administratorius',
        'prisijungimo_slaptazodis',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'prisijungimo_slaptazodis',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'registracijos_data' => 'date',
        'ar_administratorius' => 'boolean',
    ];

    // Define relationships if any
    public function atsiliepimai()
    {
        return $this->hasMany(Atsiliepimas::class, 'fk_Naudotojas', 'kliento_id');
    }

    public function mokejimai()
    {
        return $this->hasMany(Mokejimas::class, 'fk_Naudotojas', 'kliento_id');
    }

    // Add other relationships as needed
}