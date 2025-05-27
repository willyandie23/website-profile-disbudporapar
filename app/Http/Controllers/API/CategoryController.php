<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Category;

/**
 * @OA\Schema(
 *     schema="category",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Kepala Dinas"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Retrieve a list of Organization Categories",
     *     tags={"Organization Categories"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Organization Categories retrieved successfully",
     *         @OA\JsonContent(
     *            type="array",
     *             @OA\Items(ref="#/components/schemas/category")
     *         )
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
            $categories = Category::orderBy('id', 'asc')->get();

            return ApiResponseClass::success(
                $categories,
                "Organization Categories retrieved successfully"
            );
        } catch (\Throwable $e) {
            return ApiResponseClass::errorException(
                $e,
                "Failed to retrieve Organization Categories Data"
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"Organization Categories"},
     *     summary="Create a new Organization Categories",
     *     description="Create a new Organization Categories",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Organization Categories created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization Categories created successfully"),
     *             @OA\Property(
     *                 property="agency",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="name_category_value"),
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
     *             @OA\Property(property="message", type="string", example="Failed to create Organization Categories"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $categories = Category::create([
                'name' => $request->name,
            ]);
            return response()->json([
                'message' => 'Category created successfully',
                'Categories' => $categories
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Categories Organization', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Retrieve a single Organization Category by ID",
     *     tags={"Organization Categories"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Organization Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization Category retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Kepala Dinas")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organization Category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization Category not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to retrieve Organization Category"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function show($id)
    {
        try {
            $categories = Category::find($id);

            if (!$categories) {
                return response()->json(['message' => 'Organization Categories not found'], 404);
            }

            return ApiResponseClass::success($categories, "Organization Categories retrieved successfully");
        } catch (\Throwable $e) {
            return ApiResponseClass::errorException($e, "Failed to retrieve Organization Categories");
        }
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     tags={"Organization Categories"},
     *     summary="Update an existing Organization Categories",
     *     description="Update an existing Organization Categories",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the organization categories to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization categories updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization updated successfully"),
     *             @OA\Property(
     *                 property="Organization Categories",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="name_organization_updated")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organization Categories not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization Categories not found")
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
     *                     @OA\Items(type="string", example="The Organization Categories field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to update Organization Categories"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $categories = Category::find($id);
        if (!$categories) {
            return response()->json(['message' => 'Organization categories not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255' . $id,
        ]);

        try {
            $categories->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'message' => 'Organization Categories updated successfully',
                'Categories' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update Categories', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     tags={"Organization Categories"},
     *     summary="Delete a Organization Categories",
     *     description="Delete a Organization Categories by ID",
     *     security={{"bearerAuth": {}}}, 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Organization Categories ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization Categories deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categories deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organization Categories not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization Categories not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Category cannot be deleted because it is being used by one or more organizations",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Category cannot be deleted because it is being used by one or more organizations")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to delete Categories"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        // Cari kategori berdasarkan ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        try {
            // Cek apakah kategori ini digunakan oleh organisasi
            if ($category->organizations()->count() > 0) {
                return response()->json([
                    'message' => 'Masih Ada Anggota Yang Menggunakan Kategori Ini'
                ], 400);
            }

            // Hapus kategori jika tidak digunakan
            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete Category',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Method untuk view (non-API)
    public function organizationCategoriesShow()
    {
        return view('backend.organizational-structure.category.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.organizational-structure.category.create', compact('categories'));
    }

    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('backend.organizational-structure.category.edit', compact('categories'));
    }
}
