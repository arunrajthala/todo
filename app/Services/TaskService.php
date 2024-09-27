<?php

namespace App\Services;

use App\Foundation\BaseModel;
use App\Interface\TaskServiceInterface;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Exception;

/**
 * @author Arun Rajthala
 */
class TaskService implements TaskServiceInterface
{
	public function __construct(protected TaskRepository $repository)
	{
	}

	public function create(array $data = []): array
	{
		return $this->repository->create($data)->toArray();
	}

	public function getAll(array $where = []): array
	{
		$mapping = $this->statusMaps();
		return $this->repository->getAll($where)->map(function ($todo) use ($mapping) {
			$todo->status = array_flip($mapping)[$todo->status];
			return $todo;
		})->toArray();
	}

	/**
	 * Updates \App\Models\Foundation\Entities\BaseModel
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return bool
	 */
	public function update(int $id, array $data) : bool
	{

		return $this->repository->update($id, $data);
	}

	/**
	 * @param  int  $id
	 * @return bool
	 * @throws Exception
	 */
	public function delete(int $id): bool
	{
		return $this->repository->delete($id);
	}

	/**
	 * Get specific data by ID
	 *
	 * @param $id
	 * @return array
	 */
	public function getById($id): array
	{
		//make sure you have route model binding in RouteServiceProvider.php
		$todo = $this->repository->getById($id);
		$todo->status = array_flip($this->statusMaps())[$todo->status];

		return $todo->toArray();
	}

	public function changeStatus(int $statusId): bool
	{
		return true;
	}

	/**
	 * @param  int  $id
	 * @param  string  $status
	 * @return array|null
	 */
	public function updateStatus(int $id, string $status): ?array
	{
		$todo = $this->repository->getById($id);
		if ($todo->update(['status' => $this->statusMaps()[$status]])) {
			return $this->getById($id);
		}
	}

	/**
	 * @return array
	 */
	private function statusMaps(): array
	{
		return [
			'active' => BaseModel::STATUS_ACTIVE,
			'pending' => Task::STATUS_HOLD,
			'complete' => Task::STATUS_COMPLETE,
		];
	}

}
