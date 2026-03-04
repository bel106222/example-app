<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Books extends Model
{
    use HasUuids, SoftDeletes, HasFactory, Notifiable;

    //public mixed $title = '';
    //public mixed $title;
    //public mixed $title;

    /**
     * @property string $id
     * @property int $user_id
     * @property string $title
     */
    protected $fillable = [
        'user_id', //владелец книги
        'title' //название книги
    ];

    public function user() : BelongsTo //привязываем пользователя к книге 'один к одному'
    {
        return $this->belongsTo(User::class);
    }
}
