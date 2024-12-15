<?php
// app/Models/Komentaras.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentaras extends Model
{
    public $timestamps = false; // If you're not using timestamps

    protected $table = 'komentaras';
    protected $primaryKey = 'komentaro_id';

    protected $fillable = ['tekstas', 'data', 'likes_count', 'fk_Atsiliepimas', 'fk_Naudotojas'];

    public function atsiliepimas()
    {
        return $this->belongsTo(Atsiliepimas::class, 'fk_Atsiliepimas', 'atsiliepimo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_Naudotojas', 'id');
    }
}
