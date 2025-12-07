<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HoroscopeReading
 * 
 * @property int $id
 * @property int $horoscope_id
 * @property string|null $house_code
 * @property int|null $rule_id
 * @property string|null $text
 * @property string|null $rendered_by
 * @property int|null $score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Horoscope $horoscope
 * @property Rule|null $rule
 *
 * @package App\Models
 */
class HoroscopeReading extends Model
{
	protected $table = 'horoscope_readings';

	protected $casts = [
		'horoscope_id' => 'int',
		'rule_id' => 'int',
		'score' => 'int'
	];

	protected $fillable = [
		'horoscope_id',
		'house_code',
		'rule_id',
		'text',
		'rendered_by',
		'score'
	];

	public function horoscope()
	{
		return $this->belongsTo(Horoscope::class);
	}

	public function rule()
	{
		return $this->belongsTo(Rule::class);
	}
}
