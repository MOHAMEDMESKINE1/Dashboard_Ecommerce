<?php
namespace  App\Repositories;

use App\Models\Category;
use App\Utils\ImageUpload;
use App\Repositories\RepositoryInterface;

//  ----------------------THIS CLASS IS ONLY FOR DATABASE_QUERIES----------------------
class CategoryRepository implements RepositoryInterface {

    public $category;

    public function __construct(Category $category)
    {
        return $this->category = $category;
    }
    public function baseQuery($relations=[]){

        $query = $this->category->select('*')->with($relations);
        
        return  $query;

    }

    public function getMainCategories(){

        $categories = $this->category->where('parent_id',0)->orWhere('parent_id',null)->get();

        return $categories;

    }

    public function store($params){
        
        $Category_create = $this->category->create($params);

        return $Category_create;
    }
     
    public function getById($id,$childrenCount = false){
      
        // $query = $this->category->where("id",$id);
        $query = $this->category->find($id);
        
        if($childrenCount){
        
            $query->withCount('child');
        }
        return  $query ->firstOrFail();

    }
    public function update($id,$params){

        $Category = $this->getById($id);

        $params['parent_id'] = $params['parent_id']?? 0;
       
        if(isset($params['image'])){

            $params['image']= ImageUpload::uploadImage($params['image']);
        }

        $Category_update = $Category->update($params);

        return $Category_update;

    }
    public function delete($request){

      return   $this->category->whereId($request->id)->delete();
    }
}

