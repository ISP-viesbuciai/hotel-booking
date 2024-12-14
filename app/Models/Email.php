<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    public $timestamps = false;

    // Specify the table name if it's not pluralized by default
    protected $table = 'el_laiskas';

    // Define the fillable fields (columns we want to insert)
    protected $fillable = [
        'siuntejo_el_pastas', // sender's email
        'gavejo_el_pastas',   // recipient's email (hardcoded)
        'tema',               // subject
        'tekstas',            // message body
        'laikas',             // time
        'fk_Naudotojas',      // foreign key for user
    ];
}
