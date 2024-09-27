<?php


namespace App\Interface;


use App\Foundation\BaseModel;
use Illuminate\Support\Collection;

/**
 * @author Arun Rajthala
 */
interface CrudRepositoryInterface
{
	/**
     * @param integer $id
     * @return BaseModel|null
     */
    public function getById(int $id) : ?BaseModel;

	/**
	 * @param  array  $where
	 * @return Collection|null
	 */
	public function getAll(array $where) : ?Collection;

	/**
	 * @param  int  $id
	 * @param  array  $data
	 * @return bool
	 */
	public function update(int $id, array $data) : bool;

	/**
	 * @param  int  $id
	 * @return bool
	 */
	public function delete(int $id) : bool;
}
