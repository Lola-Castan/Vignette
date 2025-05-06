<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    /** @use HasFactory<\Database\Factories\CardFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'music',
        'video',
        'description',
        'user_id',
        'card_size_id',
        // ajoutez d'autres champs si besoin
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function cardSize()
    {
        return $this->belongsTo(CardSize::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
