<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChartFourPillar
 * 
 * @property int $id
 * @property int $horoscope_id
 * @property string $pillar_type
 * @property string|null $heavenly_stem
 * @property string|null $earthly_branch
 * @property string|null $element
 * @property array|null $hidden_stems
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Horoscope $horoscope
 *
 * @package App\Models
 */
class ChartFourPillar extends Model
{
	protected $table = 'chart_four_pillars';

	protected $casts = [
		'horoscope_id' => 'int',
		'hidden_stems' => 'json'
	];

	protected $fillable = [
		'horoscope_id',
		'pillar_type',
		'heavenly_stem',
		'earthly_branch',
		'element',
		'hidden_stems'
	];

	public function horoscope()
	{
		return $this->belongsTo(Horoscope::class);
	}
}
