<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasUuids, SoftDeletes, HasFactory, Notifiable;

    /**
     * @property string $id
     * @property string $serviceName
     * @property string $serviceDescription
     * @property string $categoryId
     * @property string $isFixPrice
     */
    protected $fillable = [
        'serviceName',          //название услуги
        'serviceDescription',   //описание услуги
        'categoryId',           //id категории услуг
        'isFixPrice'            //признак фиксированной цены
    ];

    public function category() : BelongsTo //привязываем услугу к её категории
    {
        return $this->belongsTo(Category::class);
    }

    public function price() : BelongsToMany //привязываем услугу к её стоимости
    {
        return $this->belongsToMany(Price::class);
    }
}
