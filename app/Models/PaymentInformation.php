<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInformation extends Model
{
    use HasFactory;

    protected $table = 'payment_information'; // Ensure this matches your table name

    protected $fillable = [
        'Korteles_nr',
        'Korteles_savininkas',
        'Galiojimo_data',
        'CVV',
        'Atsiskaitymo_adresas',
        'fk_Mokejimas',
    ];

    public function mokejimas()
    {
        return $this->belongsTo(Mokejimas::class, 'fk_Mokejimas');
    }
}