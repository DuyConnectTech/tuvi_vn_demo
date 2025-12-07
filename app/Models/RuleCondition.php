<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RuleCondition
 * 
 * @property int $id
 * @property int $rule_id
 * @property string $type
 * @property string|null $field
 * @property string|null $operator
 * @property array $value
 * @property int|null $or_group
 * @property string|null $house_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Rule $rule
 *
 * @package App\Models
 */
class RuleCondition extends Model
{
	protected $table = 'rule_conditions';

	protected $casts = [
		'rule_id' => 'int',
		'value' => 'json',
		'or_group' => 'int'
	];

	protected $fillable = [
		'rule_id',
		'type',
		'field',
		'operator',
		'value',
		'or_group',
		'house_code'
	];

	public function rule()
	{
		return $this->belongsTo(Rule::class);
	}
}
