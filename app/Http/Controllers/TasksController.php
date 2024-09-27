<?php

namespace App\Http\Controllers;

use App\Foundation\ApiController;

class TasksController extends ApiController
{
	public function setValidationRule(): void
	{
		$this->validationRules = [
			'title' => 'required',
			'due_date' => 'required',
		];
		$this->validationMessage = [
			'tasks.title' => __('Please provide title.'),
			'tasks.due_date' => __('Please provide due date.'),
		];

	}
}
