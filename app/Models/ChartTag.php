<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChartTag
 * 
 * @property int $id
 * @property int $horoscope_id
 * @property int $tag_id
 * @property Carbon $created_at
 * 
 * @property Horoscope $horoscope
 * @property Tag $tag
 *
 * @package App\Models
 */
class ChartTag extends Model
{
	protected $table = 'chart_tags';
	public $timestamps = false;

	protected $casts = [
		'horoscope_id' => 'int',
		'tag_id' => 'int'
	];

	protected $fillable = [
		'horoscope_id',
		'tag_id'
	];

	public function horoscope()
	{
		return $this->belongsTo(Horoscope::class);
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
