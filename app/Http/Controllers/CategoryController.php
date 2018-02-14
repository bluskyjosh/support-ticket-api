<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Mockery\Exception;


class CategoryController extends Controller
{
    //

    public function index(CategoryRequest $request) {
        return $this->response(Category::all(), 200);
    }

    public function store(CategoryRequest $request) {
        $data = $request->all();
        try {
            $category = Category::create($data);
        }
        catch (\Exception $ex) {
            throw $ex;
        }
        return $this->response($category, 200);
    }

    public function show(CategoryRequest $request, int $id) {
        $category = Category::findOrFail($id);
        return $this->response($category, 200);
    }

    public function update(CategoryRequest $request, int $id) {
        $category = Category::findOrFail($id);
        $data = $request->all();

        try {
            $category->update($data);
        }
        catch (\Exception $ex) {
            throw $ex;
        }

        $category = $category->fresh();
        return $this->response($category, 200);
    }

    public function destroy(CategoryRequest $request, int $id) {
        $category = Category::findOrFail($id);

        try {
            if ($category->tickets->count() > 0) {
                throw new \Exception(['message' => 'Cannot delete a category in use.']);

            }
            $category->delete();
        }
        catch (\Exception $ex) {
            throw $ex;
        }

        return $this->response('', 204);
    }
}
