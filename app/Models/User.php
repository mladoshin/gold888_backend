<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'region_id',
        'branch_id',
        'name',
        'surname',
        'email',
        'password',
        'phone',
        'image',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function roles() :array
    {
        return [
            'admin' => 'Админстратор',
            'region_director' => 'Регионалный директор',
            'branch_director' => 'Директор филиала',
            'user' => 'Пользователь',
            'director' => 'Руководитель'
        ];
    }

    public function getFullNameAttribute() :string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getImagePathAttribute() :string
    {
        return config('app.url').asset('users/'.$this->image);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class)->withDefault(['name' => 'region not selected']);;
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class)->withDefault(['name' => 'branch not selected']);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'user_branch');
    }

}
