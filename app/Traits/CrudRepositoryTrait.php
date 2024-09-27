<?php

namespace App\Traits;

use App\Foundation\BaseModel;
use Illuminate\Support\Collection;

/**
 * @author Arun Rajthala
 */
trait CrudRepositoryTrait
{

	public function __construct(protected BaseModel $model)
	{
	}

	public function getAll(array $where): ?Collection
	{
		return $this->model->query()->where($where)->get();
	}

	/**
	 * Get specific data by ID
	 *
	 * @param  int  $id
	 * @return BaseModel|null
	 */
	public function getById(int $id): ?BaseModel
	{
		return $this->model->find($id);
	}

	/**
	 * Create specific data
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function create(array $data = []): mixed
	{
		return $this->model->create($data);
	}

	/**
	 * @param  int  $id
	 * @param  array  $input
	 * @return bool
	 */
	public function update(int $id, array $input = []): bool
	{
		return $this->getById($id)->update($input);
	}

	/**
	 * @param  int  $id
	 * @return bool
	 */
	public function delete(int $id): bool
	{
		return $this->getById($id)?->delete();
	}
}
