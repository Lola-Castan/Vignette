<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardSize extends Model
{
    use HasFactory;
    
    // Table associée au modèle
    protected $table = 'card_sizes'; 

    // Par défaut une PK nommée id a été généré autoincrementé
    protected $primaryKey = 'id'; 
    public $incrementing = true; 

    protected $fillable = ['name', 'width', 'height'];

    // Par défaut des champs created_at et updated_at ont été générés
    public $timestamps = true;
    
    /**
     * Get the cards associated with this size.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
