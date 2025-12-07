<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HoroscopeHouseStar
 * 
 * @property int $id
 * @property int $horoscope_house_id
 * @property int $star_id
 * @property string|null $status
 * @property bool $is_transit
 * @property string|null $source_text
 * @property int|null $order
 * @property array|null $extra
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property HoroscopeHouse $horoscope_house
 * @property Star $star
 *
 * @package App\Models
 */
class HoroscopeHouseStar extends Model
{
	protected $table = 'horoscope_house_stars';

	protected $casts = [
		'horoscope_house_id' => 'int',
		'star_id' => 'int',
		'is_transit' => 'bool',
		'order' => 'int',
		'extra' => 'json'
	];

	protected $fillable = [
		'horoscope_house_id',
		'star_id',
		'status',
		'is_transit',
		'source_text',
		'order',
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
