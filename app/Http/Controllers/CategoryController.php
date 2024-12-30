<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->all();
        return response()->json($categories);
    }

    public function show($id)
    {
        $category = $this->categoryRepository->find($id);
        return response()->json($category);
    }

    public function store(Request $request)
    {
        try {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        $validated['slug']= Str::slug($request->name);
        $category = $this->categoryRepository->create($validated);
        return response()->json($category, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->validator->errors()->first(), // Get the first error message
            ], 422);
        }
    }

    public function update(Request $request, $id)
{

    try {
        $data=$request->all();
        if($request->has('name')){
            $data['slug'] = Str::slug($request->name);
        }
        $category = $this->categoryRepository->update($id, $data);
        return response()->json($category);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => $e->validator->errors()->first(), // Get the first error message
        ], 422);
    }
}

    public function destroy($id)
    {
        $this->categoryRepository->delete($id);
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
