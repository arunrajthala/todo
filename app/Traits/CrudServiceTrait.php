<?php


namespace App\Traits;


use App\Interface\CrudRepositoryInterface;
use App\Interface\TaskRepositoryRepositoryInterface;

/**
 * @author Arun Rajthala
 */
trait CrudServiceTrait
{

	public function __construct(protected CrudRepositoryInterface $repository)
	{
	}

	public function create(array $data = []): array
	{
		return $this->repository->create($data);
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
}
