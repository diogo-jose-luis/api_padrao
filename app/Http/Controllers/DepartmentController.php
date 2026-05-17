<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/departments",
     *     operationId="departmentsIndex",
     *     tags={"Departamentos"},
     *     summary="Listar departamentos",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Lista de departamentos", @OA\JsonContent(ref="#/components/schemas/DepartmentCollectionResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse"))
     * )
     */
    public function index(): JsonResponse
    {
        $departments = Department::latest()->get();

        return $this->successResponse('Lista de departamentos.', DepartmentResource::collection($departments));
    }

    /**
     * @OA\Post(
     *     path="/departments",
     *     operationId="departmentsStore",
     *     tags={"Departamentos"},
     *     summary="Criar departamento",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreDepartmentRequest")),
     *     @OA\Response(response=201, description="Departamento criado", @OA\JsonContent(ref="#/components/schemas/DepartmentResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=422, description="Erro de validação", @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse"))
     * )
     */
    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $department = Department::create($request->validated());

        return $this->successResponse('Departamento criado com sucesso.', new DepartmentResource($department), 201);
    }

    /**
     * @OA\Get(
     *     path="/departments/{department}",
     *     operationId="departmentsShow",
     *     tags={"Departamentos"},
     *     summary="Detalhes do departamento",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="department", in="path", required=true, description="ID do departamento", @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Detalhes do departamento", @OA\JsonContent(ref="#/components/schemas/DepartmentResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse"))
     * )
     */
    public function show(Department $department): JsonResponse
    {
        return $this->successResponse('Detalhes do departamento.', new DepartmentResource($department));
    }

    /**
     * @OA\Put(
     *     path="/departments/{department}",
     *     operationId="departmentsUpdate",
     *     tags={"Departamentos"},
     *     summary="Atualizar departamento",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="department", in="path", required=true, description="ID do departamento", @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateDepartmentRequest")),
     *     @OA\Response(response=200, description="Departamento atualizado", @OA\JsonContent(ref="#/components/schemas/DepartmentResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse")),
     *     @OA\Response(response=422, description="Erro de validação", @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse"))
     * )
     */
    public function update(UpdateDepartmentRequest $request, Department $department): JsonResponse
    {
        $department->update($request->validated());

        return $this->successResponse('Departamento atualizado com sucesso.', new DepartmentResource($department));
    }

    /**
     * @OA\Delete(
     *     path="/departments/{department}",
     *     operationId="departmentsDestroy",
     *     tags={"Departamentos"},
     *     summary="Remover departamento",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="department", in="path", required=true, description="ID do departamento", @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Departamento removido", @OA\JsonContent(ref="#/components/schemas/MessageResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse"))
     * )
     */
    public function destroy(Department $department): JsonResponse
    {
        $department->delete();

        return $this->successResponse('Departamento removido com sucesso.');
    }
}
