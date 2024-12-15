<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mokejimas extends Model
{
    use HasFactory;

    protected $table = 'mokejimas'; // Ensure this matches your table name
    protected $primaryKey = 'mokejimo_id'; // Ensure this matches your primary key

    protected $fillable = [
        'data',
        'apmokejimo_budas',
        'suma',
        'fk_Rezervacija',
        'fk_Naudotojas',
    ];

    public function rezervacija()
    {
        return $this->belongsTo(Rezervacija::class, 'fk_Rezervacija');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_Naudotojas');
    }

    public function paymentInformation()
    {
        return $this->hasMany(PaymentInformation::class, 'fk_Mokejimas');
    }
}