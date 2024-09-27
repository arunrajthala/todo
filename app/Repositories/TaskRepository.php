<?php


namespace App\Repositories;


use App\Interface\CrudRepositoryInterface;
use App\Models\Task;
use App\Traits\CrudRepositoryTrait;

/**
 * @author Arun Rajthala
 */
class TaskRepository implements CrudRepositoryInterface
{
	use CrudRepositoryTrait;

	public function __construct(Task $model)
    {
		$this->model = $model;
    }

}
