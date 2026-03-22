<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $table = 'item';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'title',
        'description',
        'category',
        'cost_price',
        'sell_price',
        'img_path',
        'images',
    ];

    // ── Option 3: Laravel Scout ────────────────────────
    public function toSearchableArray()
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'category'    => $this->category,
        ];
    }

    // ── Option 2: Model Scope ──────────────────────────
    // Renamed to scopeKeyword to avoid collision with Scout's search()
    public function scopeKeyword($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title',        'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%")
              ->orWhere('category',    'LIKE', "%{$term}%");
        });
    }
}