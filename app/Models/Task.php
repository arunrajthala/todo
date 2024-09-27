<?php

namespace App\Models;

use App\Foundation\BaseModel;

/**
 * @author Arun Rajthala
 */
class Task extends BaseModel
{
	const STATUS_IN_PROGRESS = 2;

	const STATUS_HOLD = 3;

	const STATUS_COMPLETE = 4;

    protected $fillable = [
        'title',
		'due_date',
        'description',
		'status',
    ];
}
