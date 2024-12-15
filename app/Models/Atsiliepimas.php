<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atsiliepimas extends Model
{
    public $timestamps = false; // Disable automatic timestamps

    protected $primaryKey = 'atsiliepimo_id';

    protected $fillable = ['tekstas', 'ivertinimas', 'data', 'likes_count', 'fk_Naudotojas', 'fk_Kambarys'];

    public function kambarys()
    {
        return $this->belongsTo(Kambarys::class, 'fk_Kambarys');
    }

    public function user()
    {
        return $this->belongsTo(Naudotojas::class, 'fk_Naudotojas', 'id');
    }
    
    // app/Models/Atsiliepimas.php
    public function comments()
    {
        return $this->hasMany(Komentaras::class, 'fk_Atsiliepimas', 'atsiliepimo_id');
    }
}
