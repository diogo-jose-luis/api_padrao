<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/positions",
     *     operationId="positionsIndex",
     *     tags={"Cargos"},
     *     summary="Listar cargos",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Lista de cargos", @OA\JsonContent(ref="#/components/schemas/PositionCollectionResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse"))
     * )
     */
    public function index(): JsonResponse
    {
        $positions = Position::latest()->get();

        return $this->successResponse('Lista de cargos.', PositionResource::collection($positions));
    }

    /**
     * @OA\Post(
     *     path="/positions",
     *     operationId="positionsStore",
     *     tags={"Cargos"},
     *     summary="Criar cargo",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StorePositionRequest")),
     *     @OA\Response(response=201, description="Cargo criado", @OA\JsonContent(ref="#/components/schemas/PositionResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=422, description="Erro de validação", @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse"))
     * )
     */
    public function store(StorePositionRequest $request): JsonResponse
    {
        $position = Position::create($request->validated());

        return $this->successResponse('Cargo criado com sucesso.', new PositionResource($position), 201);
    }

    /**
     * @OA\Get(
     *     path="/positions/{position}",
     *     operationId="positionsShow",
     *     tags={"Cargos"},
     *     summary="Detalhes do cargo",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="position", in="path", required=true, description="ID do cargo", @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Detalhes do cargo", @OA\JsonContent(ref="#/components/schemas/PositionResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse"))
     * )
     */
    public function show(Position $position): JsonResponse
    {
        return $this->successResponse('Detalhes do cargo.', new PositionResource($position));
    }

    /**
     * @OA\Put(
     *     path="/positions/{position}",
     *     operationId="positionsUpdate",
     *     tags={"Cargos"},
     *     summary="Atualizar cargo",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="position", in="path", required=true, description="ID do cargo", @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdatePositionRequest")),
     *     @OA\Response(response=200, description="Cargo atualizado", @OA\JsonContent(ref="#/components/schemas/PositionResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse")),
     *     @OA\Response(response=422, description="Erro de validação", @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse"))
     * )
     */
    public function update(UpdatePositionRequest $request, Position $position): JsonResponse
    {
        $position->update($request->validated());

        return $this->successResponse('Cargo atualizado com sucesso.', new PositionResource($position));
    }

    /**
     * @OA\Delete(
     *     path="/positions/{position}",
     *     operationId="positionsDestroy",
     *     tags={"Cargos"},
     *     summary="Remover cargo",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="position", in="path", required=true, description="ID do cargo", @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Cargo removido", @OA\JsonContent(ref="#/components/schemas/MessageResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse"))
     * )
     */
    public function destroy(Position $position): JsonResponse
    {
        $position->delete();

        return $this->successResponse('Cargo removido com sucesso.');
    }
}
