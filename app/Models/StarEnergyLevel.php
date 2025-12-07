<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StarEnergyLevel
 * 
 * @property int $id
 * @property string $star_slug
 * @property string $branch_code
 * @property string $energy_level
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Star $star
 *
 * @package App\Models
 */
class StarEnergyLevel extends Model
{
	protected $table = 'star_energy_levels';

	protected $fillable = [
		'star_slug',
		'branch_code',
		'energy_level'
	];

	public function star()
	{
		return $this->belongsTo(Star::class, 'star_slug', 'slug');
	}
}
