<?php
namespace  App\Repositories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\RepositoryInterface;
use App\Utils\ImageUpload;

//  ----------------------THIS CLASS IS ONLY FOR DATABASE_QUERIES----------------------

class ProductRepository implements RepositoryInterface{
    
    public $product;
    public function __construct(Product $product)
    {
        return $this->product = $product;
    }

    public function baseQuery($relations = [],$withCount=[]){
       
        return $this->product->select("*")->with($relations);

      
    }

    public function getById($id){

        return $this->product->findOrFail($id);
    }

    public function store($params){

      $product = $this->product->create($params);
    
      $images = $this->multipleUpload($params,$product);

      ProductImage::insert($images);

      return $product;
   }
    //    multiple uploadimages
    public function multipleUpload ($params,$product){
        
        $images = [] ;

        $i = 0 ;

        if(isset($params["images"])){

            foreach($params["images"] as $key=>$value){

                $images [$i]["image"]  = ImageUpload::uploadImage($value);

                $images [$i] ["product_id"] = $product->id;

                $i++;
            }
        }
        return $images;
        
       
    }
   public function update($id,$params){

        // id for update
        $product =  $this->getById($id);
        $product =  $product->update($params);
        
        // id for multiupload
        $product =  $this->getById($id);
        $images  =  $this->multipleUpload($params,$product);
        
        ProductImage::insert($images);

        return $product;
   }

   public function delete($params){
    
        $product =$this->getById($params['id']);

        return $product->delete();
   }
   public function addColor($product, $params)
   {
       $product->productColor()->createMany($params['colors']);
   }
}