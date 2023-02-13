<?php
namespace App\Services;

use App\Utils\ImageUpload;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Facades\DataTables;

// -------------------THIS CLASS ONLY FOR  GETTING DATABSE DATA FROM PRODUCT_REPOSITORY-------------------

class ProductService {


    public $productRepository;

    public function __construct(ProductRepository $repo)
    {
        return $this->productRepository = $repo;
    }

    public function getAll(){

        return $this->productRepository->baseQuery();
    }

    public function getById($id){
        
        return $this->productRepository->getById($id);

    }

    public function store( $params){

        if (isset($params['image'])) {
            
            $params['image'] = ImageUpload::uploadImage($params['image']);
        }

        if (isset($params['colors'])) {

            $params['color'] = implode(',' , $params['colors']);
            unset($params['colors']);
        }
       
            
          if (isset($params['sizes'])) {

                $params['size'] = implode(',' , $params['sizes']);
                unset($params['sizes']);
            }

        $product = $this->productRepository->store($params);

        //   $this->productRepository->addColor($product, ['colors' => $params['colors']]);

        


        return $product;
    }

    public function update($id,$params){

        if (isset($params['image'])) {

            $params['image'] = ImageUpload::uploadImage($params['image']);
        }
        
        if (isset($params['colors'])) {

          $params['color'] = implode(',' , $params['colors']);
          unset($params['colors']);
        }
       
        if (isset($params['sizes'])) {

            $params['size'] = implode(',' , $params['sizes']);

            unset($params['sizes']);
        }

       
        return $this->productRepository->update($id,$params);
    }

    public function delete($params){

        return $this->productRepository->delete($params);
    }
    public function datatable(){

        $query = $this->productRepository->baseQuery(relations:['category']);
   

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return $btn='
                            <div class="d-flex justify-items-center  justify-content-between">
                                <a href="' . Route('dashboard.products.edit',$row->id) .'" class="btn btn-primary btn-sm edit-product mx-2" data-id="' . $row->id . '">Edit</a> <br>
                                
                                <button type="button" id="deleteBtn"  data-id="' . $row->id . '" class="btn btn-danger mt-md-0 mt-2" data-bs-toggle="modal"
                                data-original-title="test" data-bs-target="#deletemodal"><i class="fa fa-trash"></i>
                                </button>
                            </div>                        
                        ';
            })
            // ->addColumn('category', function ($row) {
            //   if($row->category->name){
            //     return $row->category->name;
            //   }
            // })
            ->rawColumns(['action'])
            ->make(true);
        
    }        
    

}