<?php

namespace App\Http\Controllers\API;

/**
 * @OA\Info(
 *     title="Website Profile Disbudporapar API",
 *     version="1.0.0",
 *     description="API untuk Elektronik Survei Kepuasan Masyarakat (E-SKM) Pemerintah Kabupaten Katingan. Digunakan untuk mengelola autentikasi pengguna, data pengguna, dan survei kepuasan terhadap layanan perangkat daerah.",
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your Bearer token in the format: Bearer <token>"
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="role", type="string", example="admin"),
 *     @OA\Property(property="agency_id", type="integer", nullable=true, example=1)
 * )
 *
 * @OA\Schema(
 *     schema="Period",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="period", type="string", example="2023"),
 *     @OA\Property(property="deadline", type="string", format="date", example="2023-12-31"),
 * )
 * 
 * 
 * @OA\Schema(
 *     schema="Survey",
 *     type="object",
 *     title="Survey",
 *     description="Survey model",
 *     @OA\Property(property="id", type="integer", example=1, description="The survey ID"),
 *     @OA\Property(property="user_id", type="integer", example=1, description="The ID of the user who created the survey"),
 *     @OA\Property(property="title", type="string", example="Survey Title", description="The title of the survey"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-16T12:00:00Z", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-16T12:00:00Z", description="Last update timestamp")
 * )
 */
class OpenApi
{
    // File ini hanya untuk anotasi, tidak perlu logika
}
