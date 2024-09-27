<?php

namespace App\Http\Controllers;

use App\Foundation\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

	/**
	 * @param  Request  $request
	 * @param int $id
	 * @return JsonResponse
	 */
	public function updateStatus(int $id, Request $request) : JsonResponse
	{
		$validatedData = $request->validate([
			'status' => 'required|in:active,pending,complete'
		]);
		return response()->json($this->service->updateStatus($id, $validatedData['status']));
	}

}
