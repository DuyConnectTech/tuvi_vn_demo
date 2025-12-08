<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Star
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $group_type
 * @property string|null $default_element
 * @property bool $is_main
 * @property string|null $quality
 * @property array|null $aliases
 * @property array|null $keywords
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|HoroscopeHouse[] $horoscope_houses
 * @property Collection|StarEnergyLevel[] $star_energy_levels
 *
 * @package App\Models
 */
class Star extends Model
{
	protected $table = 'stars';

	protected $casts = [
		'is_main' => 'bool',
		'aliases' => 'json',
		'keywords' => 'json'
	];

	protected $fillable = [
		'name',
		'slug',
		'group_type',
		'default_element',
		'is_main',
		'quality',
		'aliases',
		'keywords',
		'description'
	];

	public function horoscope_houses()
	{
		return $this->belongsToMany(HoroscopeHouse::class, 'horoscope_house_stars')
			->withPivot('id', 'status', 'is_transit', 'source_text', 'order', 'extra')
			->withTimestamps();
	}

	public function horoscope_house_stars()
	{
		return $this->hasMany(HoroscopeHouseStar::class);
	}

	/**
	 * Get the color hex code based on the star's element.
	 * tuvi.vn style colors.
	 */
	public function getColorAttribute()
	{
		return match ($this->default_element) {
			'Kim' => '#999999', // Gray
			'Mộc' => '#009130', // Green
			'Thủy' => '#000000', // Black
			'Hỏa' => '#ff0000', // Red
			'Thổ' => '#ffa000', // Orange/Yellow
			default => '#333333'
		};
	}
}
