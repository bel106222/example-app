<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Concerns\HasUuids;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property integer $organization_id
 * @property boolean $is_admin
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, SoftDeletes, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_admin',
        'organization_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function avatar() : HasOne
    {
        return $this->hasOne(Avatar::class);
    }

    public function book() : BelongsTo //привязываем пользователя к книге 'один к одному'
    {
        return $this->belongsTo(Books::class);
    }

    public function organization() : HasOne
    {
        return $this->hasOne(Organization::class);
    }

//    //Акцессор (представляет полученные из БД строки в верхнем регистре)
//    public function getNameAttribute(): string
//    {
//        return Str::upper($this->attributes['name']);
//    }
//    //Мутатор
//    public function setSlugAttribute(string $name): void
//    {
//        $this->attributes['name'] = Str::upper($name);
//    }
}
