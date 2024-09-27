<?php

namespace App\Services;

use App\Interface\TaskServiceInterface;
use App\Models\Task;
use App\Repositories\TaskRepository;

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

	public function getAll(array $where = []) : array
    {
        return $this->repository->getAll($where)->all();
    }

    /**
     * Updates \App\Models\Foundation\Entities\BaseModel
     *
     * @param int $id
     * @param array $data
     * @return bool|mixed
     */
    public function update(int $id, array $data)
    {

        return $result = $this->repository->update($id, $data);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id) : bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get specific data by ID
     *
     * @param $id
     * @return array
     */
    public function getById($id) : array
    {
        //make sure you have route model binding in RouteServiceProvider.php
        return $this->repository->getById($id)->toArray();
    }

	public function changeStatus(int $statusId): bool
	{
		return true;
	}

}
