<?php
namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Utils\ImageUpload;
use Yajra\DataTables\Facades\DataTables;

// -------------------THIS CLASS ONLY FOR  GETTING DATABSE DATA FROM CATEGORY_REPOSITORY-------------------
class CategoryService {

    public $categoryRepository;
    
    public function __construct(CategoryRepository $repo)
    {
        return $this->categoryRepository = $repo; 
    }
    public  function getMainCategories(){

        
        return $this->categoryRepository->getMainCategories();

    }
  
    public function getById($id,$childrenCount = false){
      
        $getById = $this->categoryRepository->getById($id,$childrenCount);

        return $getById;

    }

    public function update($id,$params){
        

       return $this->categoryRepository->update($id,$params);

    }

    public function store($params){

        $params['parent_id'] = $params['parent_id'] ?? 0;

        if(isset($params['image'])){

            $params['image'] = ImageUpload::uploadImage($params['image']);
        }
        
        $store  = $this->categoryRepository->store($params);


        return $store;


    }
    public function delete($request){

        return $this->categoryRepository->delete($request);
    }

    public function datatable(){

        $query = $this->categoryRepository->baseQuery("parent");

        return  DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
                        <a href="' . Route('dashboard.categories.edit', $row->id) . '"  class="edit btn btn-secondary btn-sm" ><i class="fa fa-edit"></i></a>
                        <button type="button" id="deleteBtn"  data-id="' . $row->id . '" class="btn btn-danger mt-md-0 mt-2" data-bs-toggle="modal"
                        data-original-title="test" data-bs-target="#deletemodal"><i class="fa fa-trash"></i></button>';
            })

            ->addColumn('parent', function ($row) {
                
                if ($row->parent) {
                    return $row->parent->name;
                }
                return 'قسم رئيسي';

                // return ($row->parent ==  0) ? 'قسم رئيسي' :   $row->parents->name;
            })

            ->addColumn('image', function ($row) {
                $url = asset($row->image);
                // return '<img src="' . $row->image . '" width="50px" height="50px">';
                return '<img src="'.$url.'" width="50px" height="50px">';
            })

            ->rawColumns(['parent', 'action', 'image'])
            ->make(true);
    }
    public function getAll()
    {
        return $this->categoryRepository->baseQuery(['child'])->get();
    }
}