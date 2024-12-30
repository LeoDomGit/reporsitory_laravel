<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        return response()->json($this->roleRepository->all());
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
            ]);

            return response()->json($this->roleRepository->create($data));
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->validator->errors()->first(), // Get the first error message
            ], 422);
        }
    }

    public function show($id)
    {
        return response()->json($this->roleRepository->find($id));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'sometimes|string|max:255|unique:roles,name,' . $id,
            ]);

            return response()->json($this->roleRepository->update($id, $data));
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->validator->errors()->first(), // Get the first error message
            ], 422);
        }
    }

    public function destroy($id)
    {
        return response()->json(['deleted' => $this->roleRepository->delete($id)]);
    }
}
