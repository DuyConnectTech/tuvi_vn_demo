<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rule
 * 
 * @property int $id
 * @property string $code
 * @property string $scope
 * @property string|null $target_house
 * @property int $priority
 * @property string $text_template
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|HoroscopeReading[] $horoscope_readings
 * @property Collection|RuleCondition[] $rule_conditions
 *
 * @package App\Models
 */
class Rule extends Model
{
	protected $table = 'rules';

	protected $casts = [
		'priority' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'code',
		'scope',
		'target_house',
		'priority',
		'text_template',
		'is_active'
	];

	public function horoscope_readings()
	{
		return $this->hasMany(HoroscopeReading::class);
	}

	public function rule_conditions()
	{
		return $this->hasMany(RuleCondition::class);
	}
}
