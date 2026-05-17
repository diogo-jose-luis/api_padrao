<?php

namespace App\OpenApi;

/**
 * @OA\Info(
 *     title="API Padrão",
 *     version="1.0.0",
 *     description="API REST com autenticação Laravel Sanctum para gestão de utilizadores, cargos e departamentos."
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="Servidor atual (usa o mesmo host e porta da documentação)"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="URL absoluta definida em APP_URL (.env)"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="Token",
 *     description="Token Bearer obtido em POST /login ou POST /register. Formato: Bearer {token}"
 * )
 *
 * @OA\Tag(name="Autenticação", description="Registo, login, logout e perfil do utilizador autenticado")
 * @OA\Tag(name="Utilizadores", description="CRUD de utilizadores (requer autenticação)")
 * @OA\Tag(name="Cargos", description="CRUD de cargos / positions (requer autenticação)")
 * @OA\Tag(name="Departamentos", description="CRUD de departamentos (requer autenticação)")
 */
class OpenApiSpecification
{
}
