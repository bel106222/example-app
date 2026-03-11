<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Price extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasUuids, SoftDeletes, HasFactory, Notifiable;

    /**
     * @property string $id
     * @property string $serviceId
     * @property float $cost
     * @property string $categoryId
     * @property boolean $isTime
     */
    protected $fillable = [
        'serviceId',            //id услуги, к которой привязана цена
        'cost',                 //стоимость услуги
        'isTime'                //признак почасовой оплаты
    ];

    public function service() : BelongsTo //привязываем цену к услуге
    {
        return $this->belongsTo(Service::class);
    }
}
