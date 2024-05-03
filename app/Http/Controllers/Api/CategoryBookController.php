<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryBook;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryBookController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = CategoryBook::all();
            return response()->json(['status' => true, 'categories' => $categories], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch categories'], 500);
        }
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categorybooks|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 400);
            }

            // Create category
            $category = CategoryBook::create([
                'name' => $request->name,
            ]);

            return response()->json(['status' => true, 'message' => 'Category created successfully', 'category' => $category], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to create category'], 500);
        }
    }

    /**
     * Display the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $category = CategoryBook::findOrFail($id);
            return response()->json(['status' => true, 'category' => $category], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categorybooks|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 400);
            }

            // Update category
            $category = CategoryBook::findOrFail($id);
            $category->update([
                'name' => $request->name,
            ]);

            return response()->json(['status' => true, 'message' => 'Category updated successfully', 'category' => $category], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to update category'], 500);
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = CategoryBook::findOrFail($id);
            $category->delete();
            return response()->json(['status' => true, 'message' => 'Category deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete category'], 500);
        }
    }
}
