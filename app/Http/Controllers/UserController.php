<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HandlesUserPhoto;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use HandlesUserPhoto;

    private const USER_RELATIONS = ['cargo', 'departamento'];

    /**
     * @OA\Get(
     *     path="/users",
     *     operationId="usersIndex",
     *     tags={"Utilizadores"},
     *     summary="Listar utilizadores",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Lista de utilizadores", @OA\JsonContent(ref="#/components/schemas/UserCollectionResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse"))
     * )
     */
    public function index(): JsonResponse
    {
        $users = User::with(self::USER_RELATIONS)->latest()->get();

        return $this->successResponse('Lista de utilizadores.', UserResource::collection($users));
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     operationId="usersStore",
     *     tags={"Utilizadores"},
     *     summary="Criar utilizador",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(mediaType="application/json", @OA\Schema(ref="#/components/schemas/StoreUserRequest")),
     *         @OA\MediaType(mediaType="multipart/form-data", @OA\Schema(ref="#/components/schemas/StoreUserRequest"))
     *     ),
     *     @OA\Response(response=201, description="Utilizador criado", @OA\JsonContent(ref="#/components/schemas/UserResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=422, description="Erro de validação", @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse"))
     * )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->safe()->except(['password', 'password_confirmation', 'fotografia']);
        $data['password'] = $request->validated('password');

        if ($request->hasFile('fotografia')) {
            $data['fotografia'] = $this->storeUserPhoto($request->file('fotografia'));
        }

        $user = User::create($data);
        $user->load(self::USER_RELATIONS);

        return $this->successResponse('Utilizador criado com sucesso.', new UserResource($user), 201);
    }

    /**
     * @OA\Get(
     *     path="/users/{user}",
     *     operationId="usersShow",
     *     tags={"Utilizadores"},
     *     summary="Detalhes do utilizador",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="user", in="path", required=true, description="ID do utilizador", @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Detalhes do utilizador", @OA\JsonContent(ref="#/components/schemas/UserResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse"))
     * )
     */
    public function show(User $user): JsonResponse
    {
        $user->load(self::USER_RELATIONS);

        return $this->successResponse('Detalhes do utilizador.', new UserResource($user));
    }

    /**
     * @OA\Put(
     *     path="/users/{user}",
     *     operationId="usersUpdate",
     *     tags={"Utilizadores"},
     *     summary="Atualizar utilizador",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="user", in="path", required=true, description="ID do utilizador", @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(mediaType="application/json", @OA\Schema(ref="#/components/schemas/UpdateUserRequest")),
     *         @OA\MediaType(mediaType="multipart/form-data", @OA\Schema(ref="#/components/schemas/UpdateUserRequest"))
     *     ),
     *     @OA\Response(response=200, description="Utilizador atualizado", @OA\JsonContent(ref="#/components/schemas/UserResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse")),
     *     @OA\Response(response=422, description="Erro de validação", @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse"))
     * )
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $data = $request->safe()->except(['password', 'password_confirmation', 'fotografia']);

        if ($request->filled('password')) {
            $data['password'] = $request->validated('password');
        }

        if ($request->hasFile('fotografia')) {
            $this->deleteUserPhoto($user->fotografia);
            $data['fotografia'] = $this->storeUserPhoto($request->file('fotografia'));
        }

        $user->update($data);
        $user->load(self::USER_RELATIONS);

        return $this->successResponse('Utilizador atualizado com sucesso.', new UserResource($user));
    }

    /**
     * @OA\Delete(
     *     path="/users/{user}",
     *     operationId="usersDestroy",
     *     tags={"Utilizadores"},
     *     summary="Remover utilizador",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="user", in="path", required=true, description="ID do utilizador", @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Utilizador removido", @OA\JsonContent(ref="#/components/schemas/MessageResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404, description="Não encontrado", @OA\JsonContent(ref="#/components/schemas/NotFoundResponse"))
     * )
     */
    public function destroy(User $user): JsonResponse
    {
        $this->deleteUserPhoto($user->fotografia);
        $user->delete();

        return $this->successResponse('Utilizador removido com sucesso.');
    }
}
