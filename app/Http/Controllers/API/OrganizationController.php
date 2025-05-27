<?php

namespace App\Http\Controllers\API;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Category;

/**
 * @OA\Schema(
 *     schema="organization",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="position", type="string", example="Kepala Dinas"),
 *     @OA\Property(property="cateogry_id", type="string", example="Kepala Dinas"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/organizations",
     *     summary="Retrieve a list of Organizations",
     *     tags={"Organization"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Organization retrieved successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Forbidden")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $organizations = Organization::with('category')->orderBy('id', 'asc')->get();

            return ApiResponseClass::success(
                $organizations,
                "Organization retrieved successfully"
            );
        } catch (\Throwable $e) {
            return ApiResponseClass::errorException(
                $e,
                "Failed to retrieve Organization Data"
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/organizations",
     *     tags={"Organization"},
     *     summary="Create a new Organization",
     *     description="Create a new Organization",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="position", type="string"),
     *             @OA\Property(property="category_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Organizaion created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organizaion created successfully"),
     *             @OA\Property(
     *                 property="organization",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="name_value"),
     *                 @OA\Property(property="position", type="string", example="position_value")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Token invalid or missing",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="key",
     *                     type="array",
     *                     @OA\Items(type="string", example="The key field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to create Organizaion"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        try {
            $organizations = Organization::create([
                'name' => $request->name,
                'position' => $request->position,
                'category_id' => $request->category_id,
            ]);

            return response()->json([
                'message' => 'Organization created successfully',
                'Organization' => $organizations
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Organization', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     summary="Retrieve a single Organization by ID",
     *     tags={"Organization"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Organization ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Example Organization"),
     *             @OA\Property(property="position", type="string", example="Example position"),
     *             @OA\Property(property="category", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Example Category")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organization not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to retrieve Organization"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function show($id)
    {
        try {
            $organizations = Organization::with('category')->find($id);

            if (!$organizations) {
                return response()->json(['message' => 'Organization not found'], 404);
            }

            return ApiResponseClass::success($organizations, "Organization retrieved successfully");
        } catch (\Throwable $e) {
            return ApiResponseClass::errorException($e, "Failed to retrieve Organization");
        }
    }

    /**
     * @OA\Put(
     *     path="/api/organizations/{id}",
     *     tags={"Organization"},
     *     summary="Update an existing Organization",
     *     description="Update an existing Organization",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the organization to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="position", type="string"),
     *             @OA\Property(property="category_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization updated successfully"),
     *             @OA\Property(
     *                 property="organization",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="name_updated"),
     *                 @OA\Property(property="position", type="string", example="position_updated"),
     *                 @OA\Property(property="category_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organization not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="array",
     *                     @OA\Items(type="string", example="The Organization Name field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to update Organization"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $organizations = Organization::find($id);
        if (!$organizations) {
            return response()->json(['message' => 'Organization not found'], 404);
        }

        try {
            $organizations->update([
                'name' => $request->name,
                'position' => $request->position,
                'category_id' => $request->category_id,
            ]);

            return response()->json([
                'message' => 'Organization updated successfully',
                'Organization' => $organizations
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update Organization', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/organizations/{id}",
     *     tags={"Organization"},
     *     summary="Delete a Organization",
     *     description="Delete a Organization by ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Organization ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organization not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to delete Organization"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        $organizations = Organization::find($id);
        if (!$organizations) {
            return response()->json(['message' => 'Organization not found'], 404);
        }

        try {
            $organizations->delete();
            return response()->json([
                'message' => 'Organization deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete Organization', 'error' => $e->getMessage()], 500);
        }
    }



    // Method untuk view (non-API)
    public function organizationShow()
    {
        return view('backend.organizational-structure.organizations.index');
    }

    public function create()
    {
        $organizations = Organization::all();
        $categories = Category::all();
        return view('backend.organizational-structure.organizations.create', compact('organizations', 'categories'));
    }

    public function edit($id)
    {
        $organizations = Organization::findOrFail($id);
        $categories = Category::all();
        return view('backend.organizational-structure.organizations.edit', compact('organizations', 'categories'));
    }
}
