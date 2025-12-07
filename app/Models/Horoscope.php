<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Horoscope
 * 
 * @property int $id
 * @property int|null $user_id
 * @property string $slug
 * @property string|null $name
 * @property string|null $gender
 * @property Carbon $birth_gregorian
 * @property string $timezone
 * @property int|null $birth_lunar_year
 * @property int|null $birth_lunar_month
 * @property int|null $birth_lunar_day
 * @property bool $birth_lunar_is_leap
 * @property string|null $can_chi_year
 * @property string|null $can_chi_month
 * @property string|null $can_chi_day
 * @property string|null $can_chi_hour
 * @property string|null $nap_am
 * @property string|null $am_duong
 * @property string|null $cuc
 * @property string|null $can_luong
 * @property int|null $external_chart_id
 * @property string|null $source_url
 * @property int|null $view_year
 * @property int|null $view_month
 * @property string|null $raw_html
 * @property array|null $raw_input
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|ChartFourPillar[] $chart_four_pillars
 * @property Collection|ChartTag[] $chart_tags
 * @property Collection|HoroscopeHouse[] $horoscope_houses
 * @property Collection|HoroscopeMetum[] $horoscope_meta
 * @property Collection|HoroscopeReading[] $horoscope_readings
 * @property Collection|HoroscopeTransaction[] $horoscope_transactions
 *
 * @package App\Models
 */
class Horoscope extends Model
{
	protected $table = 'horoscopes';

	protected $casts = [
		'user_id' => 'int',
		'birth_gregorian' => 'datetime',
		'birth_lunar_year' => 'int',
		'birth_lunar_month' => 'int',
		'birth_lunar_day' => 'int',
		'birth_lunar_is_leap' => 'bool',
		'external_chart_id' => 'int',
		'view_year' => 'int',
		'view_month' => 'int',
		'raw_input' => 'json'
	];

	protected $fillable = [
		'user_id',
		'slug',
		'name',
		'gender',
		'birth_gregorian',
		'timezone',
		'birth_lunar_year',
		'birth_lunar_month',
		'birth_lunar_day',
		'birth_lunar_is_leap',
		'can_chi_year',
		'can_chi_month',
		'can_chi_day',
		'can_chi_hour',
		'nap_am',
		'am_duong',
		'cuc',
		'can_luong',
		'external_chart_id',
		'source_url',
		'view_year',
		'view_month',
		'raw_html',
		'raw_input'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function chart_four_pillars()
	{
		return $this->hasMany(ChartFourPillar::class);
	}

	public function chart_tags()
	{
		return $this->hasMany(ChartTag::class);
	}

	public function horoscope_houses()
	{
		return $this->hasMany(HoroscopeHouse::class);
	}

	public function horoscope_meta()
	{
		return $this->hasMany(HoroscopeMetum::class);
	}

	public function horoscope_readings()
	{
		return $this->hasMany(HoroscopeReading::class);
	}

	public function horoscope_transactions()
	{
		return $this->hasMany(HoroscopeTransaction::class);
	}
}
