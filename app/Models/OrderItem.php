<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasUuids, SoftDeletes, HasFactory, Notifiable;

    /**
     * @property string $id
     * @property string $orderId
     * @property string $serviceId
     * @property string $userId
     * @property boolean $isOnline
     * @property int $quantity
     * @property float $cost
     */
    protected $fillable = [
        'orderId',          //id заказа
        'serviceId',        //id услуги
        'userId',           //id инженера-исполнителя
        'isOnline',         //признак удалённого выполнения
        'quantity',         //количество услуг
        'cost'              //стоимость услуг
    ];

    public function user() : BelongsTo //привязываем инженера-исполнителя к позиции заказа
    {
        return $this->belongsTo(User::class);
    }
    public function order() : BelongsTo //привязываем позицию заказа к заказу
    {
        return $this->belongsTo(Order::class);
    }
}
