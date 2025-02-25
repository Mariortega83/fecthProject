<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artista extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nacionalidad'];

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
        $product = new Artista($request->all());
        return $product->store();
    }
    
    public function canciones(): HasMany
    {
        return $this->hasMany(Cancion::class);
    }
}
