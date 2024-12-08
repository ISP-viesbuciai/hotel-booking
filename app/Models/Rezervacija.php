<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezervacija extends Model
{
    use HasFactory;

    protected $table = 'rezervacija'; // Ensure this matches your table name
    protected $primaryKey = 'rezervacijos_id'; // Ensure this matches your primary key

    protected $fillable = [
        'rezervuotu_kambariu_nr',
        'pradzios_data',
        'pabaigos_data',
        'bendra_kaina',
        'sukurimo_data',
        'kiek_zmoniu',
        'rezervacijos_statusas',
        'fk_Kambarys',
        'fk_Naudotojas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_Naudotojas');
    }
    public function mokejimas()
    {
        return $this->hasOne(Mokejimas::class, 'fk_Rezervacija');
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'fk_Kambarys');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'rezervacijos_statusas');
    }
}