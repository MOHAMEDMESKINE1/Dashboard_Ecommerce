<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ProductController extends Controller
{
    public $productService;
    public $categoryService;

     public function __construct(ProductService $productService,CategoryService $categoryService)
     {
        $this->productService = $productService;
        $this->categoryService = $categoryService;

     }
    public function index()
    {
         return view('dashboard.products.index');
       
    }
    public function getall(){

        return  $this->productService->datatable();
       
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $categories = $this->categoryService->getAll();

       return view('dashboard.products.create',compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
       
        $this->productService->store($request->validated());

        return view('dashboard.products.index');

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
        $product= $this->productService->getById($id);

        $categories = $this->categoryService->getAll();

        return view("dashboard.products.edit",compact("product","categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,StoreProductRequest $request)
    {

       $this->productService->update($id,$request->validated());

       return view("dashboard.products.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return $this->productService->delete($id);
    }
    public function delete($id){
        
        $this->productService->delete($id);

        return view("dashboard.products.index");
    }
}
