<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HandlesUserPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HandlesUserPhoto;

    /** Relações carregadas nas respostas de autenticação. */
    private const USER_RELATIONS = ['cargo', 'departamento'];

    /**
     * Registo de novo utilizador e emissão de token.
     *
     * @OA\Post(
     *     path="/register",
     *     operationId="authRegister",
     *     tags={"Autenticação"},
     *     summary="Registar utilizador",
     *     description="Cria um novo utilizador e devolve token Sanctum com dados completos (cargo e departamento).",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StoreUserRequest")
     *         ),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/StoreUserRequest")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Utilizador registado", @OA\JsonContent(ref="#/components/schemas/AuthTokenResponse")),
     *     @OA\Response(response=422, description="Erro de validação", @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse"))
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->safe()->except(['password', 'password_confirmation', 'fotografia']);
        $data['password'] = $request->validated('password');

        if ($request->hasFile('fotografia')) {
            $data['fotografia'] = $this->storeUserPhoto($request->file('fotografia'));
        }

        $user = User::create($data);
        $user->load(self::USER_RELATIONS);

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse('Utilizador registado com sucesso.', [
            'token' => $token,
            'user' => new UserResource($user),
        ], 201);
    }

    /**
     * Login com email e password; devolve token e utilizador completo.
     *
     * @OA\Post(
     *     path="/login",
     *     operationId="authLogin",
     *     tags={"Autenticação"},
     *     summary="Login",
     *     description="Autentica com email e password. Devolve token Bearer e utilizador com cargo e departamento.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(response=200, description="Login efetuado", @OA\JsonContent(ref="#/components/schemas/AuthTokenResponse")),
     *     @OA\Response(response=401, description="Credenciais inválidas", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     *     @OA\Response(response=422, description="Erro de validação", @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse"))
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (! $user || ! Hash::check($request->validated('password'), $user->password)) {
            return $this->errorResponse('Credenciais inválidas.', null, 401);
        }

        $user->load(self::USER_RELATIONS);
        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse('Login efetuado com sucesso.', [
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Revoga apenas o token atual (Bearer).
     *
     * @OA\Post(
     *     path="/logout",
     *     operationId="authLogout",
     *     tags={"Autenticação"},
     *     summary="Logout",
     *     description="Revoga o token Bearer atual do utilizador autenticado.",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Logout efetuado", @OA\JsonContent(ref="#/components/schemas/MessageResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse"))
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse('Logout efetuado com sucesso.');
    }

    /**
     * Utilizador autenticado com cargo e departamento.
     *
     * @OA\Get(
     *     path="/me",
     *     operationId="authMe",
     *     tags={"Autenticação"},
     *     summary="Perfil autenticado",
     *     description="Devolve o utilizador autenticado com cargo e departamento.",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Utilizador autenticado", @OA\JsonContent(ref="#/components/schemas/UserResponse")),
     *     @OA\Response(response=401, description="Não autenticado", @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse"))
     * )
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load(self::USER_RELATIONS);

        return $this->successResponse('Utilizador autenticado.', new UserResource($user));
    }
}
