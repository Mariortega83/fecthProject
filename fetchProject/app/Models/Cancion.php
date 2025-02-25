<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cancion extends Model
{
    use HasFactory;
protected $table = 'canciones';
    protected $fillable = ['artista', 'nombre', 'duracion', 'genero'];

    
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    function store() {
        try{
            $result = $this->save();
        } catch(\Exception $e) {
            $result = false;
            
        }
        return $result;
    }

    function modify($request) {
        $result = false;
        try {
            $result = $this->update($request->all());
        } catch(\Exception $e) {
        }
        return $result;
    }

    static function change($request){
        $product = new Cancion($request->all());
        return $product->store();
    }

        
}
