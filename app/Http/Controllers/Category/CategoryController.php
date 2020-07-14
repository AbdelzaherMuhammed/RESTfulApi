<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;


class CategoryController extends ApiController
{
    public function __construct()
    {
        Parent::__construct();

        $this->middleware('transform.input:' . CategoryTransformer::class)->only(['store,update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = Category::all();
        return $this->showAll($users);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required|min:25',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $category = Category::create($data);

        return $this->successResponse($category ,200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'description' => 'min:25',
        ];

        $this->validate($request, $rules);

        $category = Category::findOrFail($id);

        $category->update($request->all());

        return $this->successResponse($category ,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
