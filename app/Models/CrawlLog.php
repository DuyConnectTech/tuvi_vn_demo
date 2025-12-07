<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CrawlLog
 * 
 * @property int $id
 * @property int|null $horoscope_id
 * @property string|null $source_url
 * @property int|null $status_code
 * @property int|null $response_length
 * @property Carbon|null $crawled_at
 * @property string|null $raw_html
 * @property string|null $notes
 *
 * @package App\Models
 */
class CrawlLog extends Model
{
	protected $table = 'crawl_logs';
	public $timestamps = false;

	protected $casts = [
		'horoscope_id' => 'int',
		'status_code' => 'int',
		'response_length' => 'int',
		'crawled_at' => 'datetime'
	];

	protected $fillable = [
		'horoscope_id',
		'source_url',
		'status_code',
		'response_length',
		'crawled_at',
		'raw_html',
		'notes'
	];
}
