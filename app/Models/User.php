<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|HoroscopeTransaction[] $horoscope_transactions
 * @property Collection|Horoscope[] $horoscopes
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

	protected $table = 'users';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
	protected $casts = [
		'email_verified_at' => 'datetime',
        'password' => 'hashed'
	];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
	protected $hidden = [
		'password',
		'remember_token'
	];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function horoscope_transactions()
	{
		return $this->hasMany(HoroscopeTransaction::class);
	}

	public function horoscopes()
	{
		return $this->hasMany(Horoscope::class);
	}
}
