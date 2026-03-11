<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasUuids, SoftDeletes, HasFactory, Notifiable;

    /**
     * @property string $title
     * @property string $address
     * @property string $details
     * @property bool $isLegal
     */
    protected $fillable = [
        'title',    //наименование организации
        'address',  // Адрес
        'details',  // Реквизиты
        'isLegal'   // ФЛ/ЮЛ
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
