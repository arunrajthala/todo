<?php

namespace App\Foundation;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @author Arun Rajthala
 */
abstract class ApiController extends Controller
{
	abstract public function setValidationRule();


	/**
	 * @var array
	 */
	protected array $validationRules;

	/**
	 * @var array
	 */
	protected array $validationMessage;


	public function __construct(protected TaskService $service)
	{
		$this->setValidationRule();
	}

	/**
	 * List all the items in the system
	 *
	 * @return JsonResponse
	 */
	public function index(): JsonResponse
	{
		return response()->json($this->service->getAll());
	}

	/**
	 * List single item
	 *
	 * @param  int  $id
	 * @return JsonResponse
	 */
	public function show(int $id): JsonResponse
	{
		$model = $this->service->getById($id);

		return response()->json($model);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param  Request  $request
	 * @return JsonResponse
	 */
	public function update(int $id, Request $request): JsonResponse
	{
		try {
			$this->validate($request, $this->validationRules, $this->validationMessage);
			return response()->json($this->service->update($id, $request->all()));
		} catch (Exception $exception) {
			return response()->json(['errors' => $exception->validator->getMessageBag()], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return JsonResponse
	 */
	public function store(Request $request): JsonResponse
	{
		try {
			$validator = $this->validate($request, $this->validationRules, $this->validationMessage);
			return response()->json($this->service->create($request->all()));
		} catch (Exception $exception) {
			return response()->json(['errors' => $exception->validator->getMessageBag()], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
		}
	}

	/**
	 * Deletes data from the database
	 *
	 * @param  int  $id
	 * @return JsonResponse
	 * @throws Exception
	 */
	public function destroy(int $id): JsonResponse
	{
		try {
			return response()->json($this->service->delete($id));
		} catch (Exception $exception) {
			return response()->json([]);
		}
	}


}
