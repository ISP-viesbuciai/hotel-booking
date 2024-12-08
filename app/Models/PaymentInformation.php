<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInformation extends Model
{
    protected $table = 'payment_information'; // Ensure this matches your table name

    protected $fillable = [
        'Korteles_nr',
        'Korteles_savininkas',
        'Galiojimo_data',
        'CVV',
        'Atsiskaitymo_adresas',
        'fk_Mokejimas',
    ];
    public $timestamps = false; // Disable automatic timestamps
    public function mokejimas()
    {
        return $this->belongsTo(Mokejimas::class, 'fk_Mokejimas');
    }
}