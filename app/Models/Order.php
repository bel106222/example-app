<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasUuids, SoftDeletes, HasFactory, Notifiable;

    /**
     * @property string $id
     * @property string $orderNumber
     * @property string $orderDescription
     * @property string $userId
     * @property boolean $isCompleted
     * @property boolean $isPaid
     * @property float $orderSum
     */
    protected $fillable = [
        'orderNumber',      //номер заказа
        'orderDescription', //описание заказа
        'userId',           //id пользователя, чей это заказ
        'isCompleted',      //признак выполнения заказа
        'isPaid',           //признак произведённой оплаты
        'orderSum'          //сумма заказа
    ];

    public function user() : BelongsTo //привязываем пользователя к заказу
    {
        return $this->belongsTo(User::class);
    }
    public function orderItem() : HasMany //привязываем услуги к заказу
    {
        return $this->hasMany(OrderItem::class);
    }
}
