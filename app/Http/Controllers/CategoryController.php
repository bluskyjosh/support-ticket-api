<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Mockery\Exception;


class CategoryController extends AuthController
{

    /***
     * Returns list of Category Objects
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryRequest $request) {
        return $this->response(Category::all(), 200);
    }

    /***
     *
     * Creates a new Category Object
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(CategoryRequest $request) {
        $data = $request->all();
        $this->beginTransaction();
        try {
            $category = Category::create($data);
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        return $this->response($category, 200);
    }

    /***
     *
     * Returns a Category Object with corresponding $id.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryRequest $request, int $id) {
        $category = Category::findOrFail($id);
        return $this->response($category, 200);
    }

    /***
     * Updates a Category Object with the corresponding $id.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(CategoryRequest $request, int $id) {
        $category = Category::findOrFail($id);
        $data = $request->all();

        $this->beginTransaction();
        try {
            $category->update($data);
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }

        $this->commit();
        $category = $category->fresh();
        return $this->response($category, 200);
    }

    /***
     *
     * Deletes Category Object with corresponding $id.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(CategoryRequest $request, int $id) {
        $category = Category::findOrFail($id);

        $this->beginTransaction();
        try {
            if ($category->tickets->count() > 0) {
                throw new \Exception(['message' => 'Cannot delete a category in use.']);

            }
            $category->delete();
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();

        return $this->response('', 204);
    }
}
