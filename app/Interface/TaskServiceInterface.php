<?php


namespace App\Interface;


/**
 * @author Arun Rajthala
 */
interface TaskServiceInterface
{
	public function getAll() : array;

	public function update(int $id, array $data);

	public function getById(int $id) : array;

	public function delete(int $id) : bool;

	public function changeStatus (int $statusId) : bool;

	public function create(array $data) : array;

}
