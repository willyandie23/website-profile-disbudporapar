<?php

namespace App\Http\Controllers\API;

use App\Models\Identity;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class IdentityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/identities",
     *     summary="Retrieve a list of Identity",
     *     tags={"Website Identity"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Identity retrieved successfully",
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
            $identities = Identity::pluck('value', 'key')->toArray();

            return ApiResponseClass::success(
                $identities,
                "Identity retrieved successfully"
            );
        } catch (\Throwable $e) {
            return ApiResponseClass::errorException(
                $e,
                "Failed to retrieve Management Data"
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/identities",
     *     tags={"Website Identity"},
     *     summary="Create a new Identity",
     *     description="Create a new Identity",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="key", type="string"),
     *             @OA\Property(property="value", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Identity created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Identity created successfully"),
     *             @OA\Property(
     *                 property="Identity",
     *                 type="object",
     *                 @OA\Property(property="key", type="string", example="key_value"),
     *                 @OA\Property(property="value", type="string", example="value_value")
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
     *             @OA\Property(property="message", type="string", example="Failed to create Identity"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'site_heading' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,ico|max:2048',
            'cp_address' => 'nullable|string',
            'cp_phone' => 'nullable|string',
            'cp_email' => 'nullable|string',
            'cp_agency' => 'nullable|string',
            'sm_facebook' => 'nullable|string',
            'sm_instagram' => 'nullable|string',
            'sm_x' => 'nullable|string',
            'sm_youtube' => 'nullable|string'
        ]);

        try {
            // Handle logo upload
            if ($request->hasFile('site_logo')) {
                $logoPath = $request->file('site_logo')->store('logo', 'public');
                Log::info('Logo stored', ['path' => $logoPath]);
                $validatedData['site_logo'] = Storage::url($logoPath);
            }

            // Handle favicon upload
            if ($request->hasFile('site_favicon')) {
                $favicon = $request->file('site_favicon');
                Log::info('Favicon file detected', [
                    'file' => $favicon->getClientOriginalName(),
                    'size' => $favicon->getSize(),
                    'mime' => $favicon->getMimeType()
                ]);
                if ($favicon->isValid()) {
                    $faviconPath = $favicon->store('favicon', 'public');
                    Log::info('Favicon stored', ['path' => $faviconPath]);
                    $validatedData['site_favicon'] = Storage::url($faviconPath);
                } else {
                    Log::error('Invalid favicon file', ['error' => $favicon->getErrorMessage()]);
                    return response()->json(['message' => 'Invalid favicon file', 'error' => $favicon->getErrorMessage()], 422);
                }
            }

            Log::info('Validated data before saving:', $validatedData);

            // Save or update identities
            foreach ($validatedData as $key => $value) {
                Identity::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            // Verify favicon in database
            $faviconRecord = Identity::where('key', 'site_favicon')->first();
            Log::info('Favicon record in DB:', ['record' => $faviconRecord]);

            return response()->json([
                'message' => 'Identity created successfully',
                'Identity' => $validatedData
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create Identity', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create Identity', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/identities/{id}",
     *     summary="Retrieve a single Identity by ID",
     *     tags={"Website Identity"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identity ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Identity retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="key", type="string", example="example_key"),
     *             @OA\Property(property="value", type="string", example="example_value")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Identity not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Identity not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to retrieve Identity"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function show($id)
    {
        try {
            $identities = Identity::find($id);

            if (!$identities) {
                return response()->json(['message' => 'Identity not found'], 404);
            }

            return ApiResponseClass::success($identities, "Identity retrieved successfully");
        } catch (\Throwable $e) {
            return ApiResponseClass::errorException($e, "Failed to retrieve Identity");
        }
    }

    /**
     * @OA\Put(
     *     path="/api/identities/{id}",
     *     tags={"Website Identity"},
     *     summary="Update an existing Identity",
     *     description="Update an existing Identity",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identity ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="key", type="string"),
     *             @OA\Property(property="value", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Identity updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Identity updated successfully"),
     *             @OA\Property(
     *                 property="Identity",
     *                 type="object",
     *                 @OA\Property(property="key", type="string", example="key_updated"),
     *                 @OA\Property(property="value", type="string", example="value_updated")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Identity not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Identity not found")
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
     *             @OA\Property(property="message", type="string", example="Failed to update Identity"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $identities = Identity::find($id);
        if (!$identities) {
            return response()->json(['message' => 'Identity not found'], 404);
        }

        $request->validate([
            'key' => 'required|string|max:255|unique:identities,key,' . $id,
            'value' => 'required|string|max:255',
        ]);

        try {
            $identities->update([
                'key' => $request->key,
                'value' => $request->value,
            ]);

            return response()->json([
                'message' => 'Identity updated successfully',
                'Identity' => $identities
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update Identity', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/identities/{id}",
     *     tags={"Website Identity"},
     *     summary="Delete a Identity",
     *     description="Delete a Identity by ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identity ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Identity deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Identity deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Identity not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Identity not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to delete Identity"),
     *             @OA\Property(property="error", type="string", example="Database error")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        $identities = Identity::find($id);
        if (!$identities) {
            return response()->json(['message' => 'Identity not found'], 404);
        }

        try {
            $identities->delete();

            return response()->json([
                'message' => 'Identity deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete Identity', 'error' => $e->getMessage()], 500);
        }
    }

    // Method untuk view (non-API)
    public function identityShow()
    {
        return view('backend.identity.index');
    }
}
