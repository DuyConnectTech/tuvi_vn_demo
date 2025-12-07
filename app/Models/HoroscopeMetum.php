<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HoroscopeMetum
 * 
 * @property int $id
 * @property int $horoscope_id
 * @property string|null $view_year_can_chi
 * @property int|null $age_at_view
 * @property string|null $chu_menh
 * @property string|null $chu_than
 * @property string|null $lai_nhan_cung
 * @property int|null $template
 * @property int|null $theme
 * @property array|null $extra
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Horoscope $horoscope
 *
 * @package App\Models
 */
class HoroscopeMetum extends Model
{
	protected $table = 'horoscope_meta';

	protected $casts = [
		'horoscope_id' => 'int',
		'age_at_view' => 'int',
		'template' => 'int',
		'theme' => 'int',
		'extra' => 'json'
	];

	protected $fillable = [
		'horoscope_id',
		'view_year_can_chi',
		'age_at_view',
		'chu_menh',
		'chu_than',
		'lai_nhan_cung',
		'template',
		'theme',
		'extra'
	];

	public function horoscope()
	{
		return $this->belongsTo(Horoscope::class);
	}
}
