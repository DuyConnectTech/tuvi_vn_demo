<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HoroscopeHouse
 * 
 * @property int $id
 * @property int $horoscope_id
 * @property string $code
 * @property string $label
 * @property string|null $branch
 * @property string|null $element
 * @property string|null $life_phase
 * @property int $house_order
 * @property int|null $dai_van_start_age
 * @property int|null $dai_van_end_age
 * @property int|null $score
 * @property int|null $lunar_month
 * @property array|null $relations
 * @property array|null $extra
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Horoscope $horoscope
 * @property Collection|Star[] $stars
 *
 * @package App\Models
 */
class HoroscopeHouse extends Model
{
	protected $table = 'horoscope_houses';

	protected $casts = [
		'horoscope_id' => 'int',
		'house_order' => 'int',
		'dai_van_start_age' => 'int',
		'dai_van_end_age' => 'int',
		'score' => 'int',
		'lunar_month' => 'int',
		'relations' => 'json',
		'extra' => 'json'
	];

	protected $fillable = [
		'horoscope_id',
		'code',
		'label',
		'branch',
		'element',
		'life_phase',
		'house_order',
		'dai_van_start_age',
		'dai_van_end_age',
		'score',
		'lunar_month',
		'relations',
		'extra'
	];

	public function horoscope()
	{
		return $this->belongsTo(Horoscope::class);
	}

	public function stars()
	{
		return $this->belongsToMany(Star::class, 'horoscope_house_stars')
					->withPivot('id', 'status', 'is_transit', 'source_text', 'order', 'extra')
					->withTimestamps();
	}
}
