<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Categories\CategoryDelete;
use App\Http\Requests\Dashboard\Categories\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Categories\CategoryUpdateRequest;

// ------------------- THIS CLASS RECEIVE DATA FROM CATEGORY_SERVICE AND DISPLY IT  -------------
class CatgeoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // create cosntructor
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        return $this->categoryService = $categoryService;
    }
    public function index()
    {
        // $mainCategories = (new CategoryService)->getMainCategories() ;
        
        // $mainCategories =CategoryService::getMainCategories(); if we are using static methods 
       
        $mainCategories = $this->categoryService->getMainCategories();

        return view('dashboard.categories.index',compact('mainCategories'));
    }

    public function getall(){

        return $this->categoryService->datatable();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        
       
         $this->categoryService->store($request->validated());

        return redirect()->route('dashboard.categories.index')->with('success',"تمت الاضافه بنجاح");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category= $this->categoryService->getById($id,true);
        $mainCategories = $this->categoryService->getMainCategories();
        return view("dashboard.categories.edit",compact(["category","mainCategories"]));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( $id,CategoryUpdateRequest $request)
    {
        $this->categoryService->update($id,$request->validated());

        return redirect()->route('dashboard.categories.edit',$id)->with('success',"تم التعديل   بنجاح");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($request->all());
    }
    public function delete(CategoryDelete $request)
    {
        $this->categoryService->delete($request);

       return redirect()->route('dashboard.categories.index');
    }
}
