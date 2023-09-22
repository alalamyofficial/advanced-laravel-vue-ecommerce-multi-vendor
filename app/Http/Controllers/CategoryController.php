<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('is_deleted',0)->latest()->get();
        $category_details = Category::where('is_deleted',0)->where('id',request()->id)->first();
        return Inertia::render('admin/categories/index',
            ['categories' => $categories , 'category_details' => $category_details]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function all_categories(){

        $categories = Category::where('is_deleted',0)->latest()->get();

        return response()->json($categories);
        // return response()->json($categories->cursor());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        // $data = $request->all();

        $data = $request->validated(); // Get the validated data from the request.


        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }
        $category_store = Category::create($data);
        return response()->json($category_store);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json($category);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $data = $request->validated(); // Get the validated data from the request.
        $update_category = $category->update($data);
        return response()->json($update_category);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Category $category){

        $category->update(['is_deleted' => 1]);
        return response()->json($category);

    }
}
