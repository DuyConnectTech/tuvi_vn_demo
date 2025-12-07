<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LucThapHoaGiap
 * 
 * @property int $id
 * @property string $can_chi
 * @property string $can
 * @property string $chi
 * @property string $nap_am
 * @property string $ngu_hanh
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LucThapHoaGiap extends Model
{
	protected $table = 'luc_thap_hoa_giap';

	protected $fillable = [
		'can_chi',
		'can',
		'chi',
		'nap_am',
		'ngu_hanh'
	];
}
