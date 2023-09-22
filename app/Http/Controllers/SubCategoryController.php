<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_categories = SubCategory::where('is_deleted',0)->latest()->get();
        $categories = Category::where('is_deleted',0)->latest()->get();
        $sub_category_details = SubCategory::where('is_deleted',0)->where('id',request()->id)->first();
        return Inertia::render('admin/sub_categories/index',
            [   'sub_categories' => $sub_categories ,
                'sub_category_details' => $sub_category_details,
                'categories' => $categories,
            ]
        );
    }

    public function all_sub_categories(){

        $sub_categories = SubCategory::where('is_deleted',0)->latest()->get();
        return response()->json($sub_categories);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $data = $request->validated(); // Get the validated data from the request.


        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }
        $sub_category_store = SubCategory::create($data);
        return response()->json($sub_category_store);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $subCategory = SubCategory::find($id);
        return response()->json($subCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory)
    {
        $data = $request->validated(); // Get the validated data from the request.
        $update_sub_category = $subCategory->update($data);
        return response()->json($update_sub_category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->update(['is_deleted' => 1]);
        return response()->json($subCategory);
    }
}
