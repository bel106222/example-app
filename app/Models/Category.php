<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasUuids, SoftDeletes, HasFactory, Notifiable;

    /**
     * @property string $id
     * @property string $categoryName
     */
    protected $fillable = [
        'categoryName', //название категории
    ];

    public function service(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
