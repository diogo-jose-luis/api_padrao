<?php

namespace App\OpenApi;

/**
 * @OA\Schema(
 *     schema="ValidationErrorResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Dados de validação inválidos."),
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         additionalProperties=@OA\Schema(type="array", @OA\Items(type="string"))
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Credenciais inválidas.")
 * )
 *
 * @OA\Schema(
 *     schema="UnauthenticatedResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Não autenticado.")
 * )
 *
 * @OA\Schema(
 *     schema="NotFoundResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Recurso não encontrado.")
 * )
 *
 * @OA\Schema(
 *     schema="Position",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="Desenvolvedor"),
 *     @OA\Property(property="descricao", type="string", nullable=true, example="Desenvolvimento de software"),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="Department",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="Tecnologia"),
 *     @OA\Property(property="descricao", type="string", nullable=true, example="Departamento de TI"),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="João Silva"),
 *     @OA\Property(property="email", type="string", format="email", example="joao@example.com"),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="genero", type="integer", nullable=true, description="1 = Male, 2 = Female", example=1),
 *     @OA\Property(property="genero_label", type="string", nullable=true, example="Male"),
 *     @OA\Property(property="fotografia", type="string", format="uri", nullable=true),
 *     @OA\Property(property="cargo_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="departamento_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="cargo", ref="#/components/schemas/Position", nullable=true),
 *     @OA\Property(property="departamento", ref="#/components/schemas/Department", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="AuthTokenData",
 *     type="object",
 *     @OA\Property(property="token", type="string", example="1|abcdefghijklmnopqrstuvwxyz"),
 *     @OA\Property(property="user", ref="#/components/schemas/User")
 * )
 *
 * @OA\Schema(
 *     schema="AuthTokenResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Login efetuado com sucesso."),
 *     @OA\Property(property="data", ref="#/components/schemas/AuthTokenData")
 * )
 *
 * @OA\Schema(
 *     schema="UserResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Detalhes do utilizador."),
 *     @OA\Property(property="data", ref="#/components/schemas/User")
 * )
 *
 * @OA\Schema(
 *     schema="UserCollectionResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Lista de utilizadores."),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User"))
 * )
 *
 * @OA\Schema(
 *     schema="PositionResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Detalhes do cargo."),
 *     @OA\Property(property="data", ref="#/components/schemas/Position")
 * )
 *
 * @OA\Schema(
 *     schema="PositionCollectionResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Lista de cargos."),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Position"))
 * )
 *
 * @OA\Schema(
 *     schema="DepartmentResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Detalhes do departamento."),
 *     @OA\Property(property="data", ref="#/components/schemas/Department")
 * )
 *
 * @OA\Schema(
 *     schema="DepartmentCollectionResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Lista de departamentos."),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Department"))
 * )
 *
 * @OA\Schema(
 *     schema="MessageResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Logout efetuado com sucesso."),
 *     @OA\Property(property="data", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="LoginRequest",
 *     required={"email", "password"},
 *     type="object",
 *     @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password")
 * )
 *
 * @OA\Schema(
 *     schema="StoreUserRequest",
 *     required={"name", "email", "password", "password_confirmation"},
 *     type="object",
 *     @OA\Property(property="name", type="string", maxLength=255, example="João Silva"),
 *     @OA\Property(property="email", type="string", format="email", maxLength=255, example="joao@example.com"),
 *     @OA\Property(property="password", type="string", format="password", minLength=8, example="password123"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
 *     @OA\Property(property="genero", type="integer", nullable=true, enum={1, 2}, description="1 = Male, 2 = Female"),
 *     @OA\Property(property="fotografia", type="string", format="binary", nullable=true, description="Imagem (máx. 2MB)"),
 *     @OA\Property(property="cargo_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="departamento_id", type="integer", nullable=true, example=1)
 * )
 *
 * @OA\Schema(
 *     schema="UpdateUserRequest",
 *     type="object",
 *     @OA\Property(property="name", type="string", maxLength=255),
 *     @OA\Property(property="email", type="string", format="email", maxLength=255),
 *     @OA\Property(property="password", type="string", format="password", minLength=8, nullable=true),
 *     @OA\Property(property="password_confirmation", type="string", format="password", nullable=true),
 *     @OA\Property(property="genero", type="integer", nullable=true, enum={1, 2}),
 *     @OA\Property(property="fotografia", type="string", format="binary", nullable=true),
 *     @OA\Property(property="cargo_id", type="integer", nullable=true),
 *     @OA\Property(property="departamento_id", type="integer", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="StorePositionRequest",
 *     required={"nome"},
 *     type="object",
 *     @OA\Property(property="nome", type="string", maxLength=255, example="Desenvolvedor"),
 *     @OA\Property(property="descricao", type="string", nullable=true, example="Desenvolvimento de software"),
 *     @OA\Property(property="estado", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="UpdatePositionRequest",
 *     type="object",
 *     @OA\Property(property="nome", type="string", maxLength=255),
 *     @OA\Property(property="descricao", type="string", nullable=true),
 *     @OA\Property(property="estado", type="boolean")
 * )
 *
 * @OA\Schema(
 *     schema="StoreDepartmentRequest",
 *     required={"nome"},
 *     type="object",
 *     @OA\Property(property="nome", type="string", maxLength=255, example="Tecnologia"),
 *     @OA\Property(property="descricao", type="string", nullable=true, example="Departamento de TI"),
 *     @OA\Property(property="estado", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="UpdateDepartmentRequest",
 *     type="object",
 *     @OA\Property(property="nome", type="string", maxLength=255),
 *     @OA\Property(property="descricao", type="string", nullable=true),
 *     @OA\Property(property="estado", type="boolean")
 * )
 */
class Schemas
{
}
