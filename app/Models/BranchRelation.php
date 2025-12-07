<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BranchRelation
 * 
 * @property int $id
 * @property string $from_house_code
 * @property string $to_house_code
 * @property string $relation_type
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class BranchRelation extends Model
{
	protected $table = 'branch_relations';

	protected $fillable = [
		'from_house_code',
		'to_house_code',
		'relation_type',
		'description'
	];
}
