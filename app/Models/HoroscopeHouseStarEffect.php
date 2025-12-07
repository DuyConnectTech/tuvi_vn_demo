<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HoroscopeHouseStarEffect
 * 
 * @property int $id
 * @property int $horoscope_house_id
 * @property int $star_id
 * @property string|null $effect_type
 * @property string|null $target_house_code
 * @property array|null $extra
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property HoroscopeHouse $horoscope_house
 * @property Star $star
 *
 * @package App\Models
 */
class HoroscopeHouseStarEffect extends Model
{
	protected $table = 'horoscope_house_star_effects';

	protected $casts = [
		'horoscope_house_id' => 'int',
		'star_id' => 'int',
		'extra' => 'json'
	];

	protected $fillable = [
		'horoscope_house_id',
		'star_id',
		'effect_type',
		'target_house_code',
		'extra'
	];

	public function horoscope_house()
	{
		return $this->belongsTo(HoroscopeHouse::class);
	}

	public function star()
	{
		return $this->belongsTo(Star::class);
	}
}
