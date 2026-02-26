<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $user_id
 * @property string $path
  */
class Avatar extends Model
{
    protected $fillable = [
        'user_id', //владелец аватарки
        'path' //путь к файлу с аватаркой
    ];

    public function user() : BelongsTo //привязываем пользователя к аватарке 'один к одному'
    {
        return $this->belongsTo(User::class);
    }
}
