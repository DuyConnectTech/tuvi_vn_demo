<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HoroscopeTransaction
 * 
 * @property int $id
 * @property int $horoscope_id
 * @property int|null $user_id
 * @property float $amount
 * @property string $currency
 * @property string $status
 * @property array|null $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Horoscope $horoscope
 * @property User|null $user
 *
 * @package App\Models
 */
class HoroscopeTransaction extends Model
{
	protected $table = 'horoscope_transactions';

	protected $casts = [
		'horoscope_id' => 'int',
		'user_id' => 'int',
		'amount' => 'float',
		'payload' => 'json'
	];

	protected $fillable = [
		'horoscope_id',
		'user_id',
		'amount',
		'currency',
		'status',
		'payload'
	];

	public function horoscope()
	{
		return $this->belongsTo(Horoscope::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
