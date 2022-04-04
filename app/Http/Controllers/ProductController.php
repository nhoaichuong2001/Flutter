<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
class ProductController extends Controller
{
    function getAllProduct($userID){
        $data = DB::table('products')
        ->where('status',1)
        ->select('products.*')
        ->where('products.stock','>',0)
        ->orderBy('products.id','asc')
        ->addSelect(DB::raw('null as checkFavorite,null as reviews'))
        ->take(8)
        ->get();
        foreach($data as $item){
           $item->checkFavorite=  DB::table('favorites')
           ->join('favorite_details','favorites.id','favorite_details.favoriteID')
           ->where('favorites.userID',$userID)
            ->where('favorite_details.productID',$item->id)->exists();
            $item->reviews = DB::table('reviews')
            ->join('users','reviews.userID','users.id')
            ->where('reviews.status',1)
            ->where('reviews.productID',$item->id)
            ->orderBy('reviews.postedDate','desc')
            ->select('reviews.*','users.fullName','users.avatar')
            ->get();          
        }    
        return json_encode(
            $data,
        );
    }
   
    function latest($userID){
        $data = DB::table('products')
        ->where('status',1)
        ->select('products.*')
        ->where('products.stock','>',0)
        ->orderBy('products.id','desc')
        ->addSelect(DB::raw('null as checkFavorite,null as reviews'))
        ->take(3)
        ->get();
        foreach($data as $item){
           $item->checkFavorite=  DB::table('favorites')
           ->join('favorite_details','favorites.id','favorite_details.favoriteID')
           ->where('favorites.userID',$userID)
            ->where('favorite_details.productID',$item->id)->exists();
            $item->reviews = DB::table('reviews')
            ->join('users','reviews.userID','users.id')
            ->where('reviews.status',1)
            ->where('reviews.productID',$item->id)
            ->orderBy('reviews.postedDate','desc')
            ->select('reviews.*','users.fullName','users.avatar')
            ->get();          
        }    
        return json_encode(
            $data,
        );
    }

    function Fruit($userID)
    {
        $products = DB::table('products')->where('type','Trái cây') 
        ->select('products.*') ->addSelect(DB::raw('null as checkFavorite'))->get();  
        foreach($products as $item){
            $item->checkFavorite=  DB::table('favorites')
            ->join('favorite_details','favorites.id','favorite_details.favoriteID')
            ->where('favorites.userID',$userID)
             ->where('favorite_details.productID',$item->id)->exists();
             $item->reviews = DB::table('reviews')
             ->join('users','reviews.userID','=','users.id')
             ->where('reviews.productID',$item->id)
             ->orderBy('reviews.postedDate','desc')
             ->select('reviews.*','users.fullName','users.avatar')
             ->get();
            
         }     
        if($products !=null){       
            return  json_encode(
                $products,
        );  
        }
    }
  
    function Meat($userID)
    {
        $products = DB::table('products')->where('type','Thịt') 
        ->select('products.*') ->addSelect(DB::raw('null as checkFavorite'))->get();  
        foreach($products as $item){
            $item->checkFavorite=  DB::table('favorites')
            ->join('favorite_details','favorites.id','favorite_details.favoriteID')
            ->where('favorites.userID',$userID)
             ->where('favorite_details.productID',$item->id)->exists();
             $item->reviews = DB::table('reviews')
             ->join('users','reviews.userID','=','users.id')
             ->where('reviews.productID',$item->id)
             ->orderBy('reviews.postedDate','desc')
             ->select('reviews.*','users.fullName','users.avatar')
             ->get();
            
         }     
        if($products !=null){       
            return  json_encode(
                $products,
        );  
        }
    }

    function Drink($userID)
    {
        $products = DB::table('products')->where('type','Thức uống') 
        ->select('products.*') ->addSelect(DB::raw('null as checkFavorite'))->get();  
        foreach($products as $item){
            $item->checkFavorite=  DB::table('favorites')
            ->join('favorite_details','favorites.id','favorite_details.favoriteID')
            ->where('favorites.userID',$userID)
             ->where('favorite_details.productID',$item->id)->exists();
             $item->reviews = DB::table('reviews')
             ->join('users','reviews.userID','=','users.id')
             ->where('reviews.productID',$item->id)
             ->orderBy('reviews.postedDate','desc')
             ->select('reviews.*','users.fullName','users.avatar')
             ->get();
            
         }     
        if($products !=null){       
            return  json_encode(
                $products,
        );  
        }
    }

    function Vegetable($userID)
    {
        $products = DB::table('products')->where('type','Rau củ') 
        ->select('products.*') ->addSelect(DB::raw('null as checkFavorite'))->get();  
        foreach($products as $item){
            $item->checkFavorite=  DB::table('favorites')
            ->join('favorite_details','favorites.id','favorite_details.favoriteID')
            ->where('favorites.userID',$userID)
             ->where('favorite_details.productID',$item->id)->exists();
             $item->reviews = DB::table('reviews')
             ->join('users','reviews.userID','=','users.id')
             ->where('reviews.productID',$item->id)
             ->orderBy('reviews.postedDate','desc')
             ->select('reviews.*','users.fullName','users.avatar')
             ->get();
            
         }     
        if($products !=null){       
            return  json_encode(
                $products,
        );  
        }
    }
    function getProductBestSeller(){
                $data = DB::table('invoices')
                ->join('invoice_details','invoices.id','=','invoice_details.invoiceID')
                ->join('products','invoice_details.productID','=','products.id')
                ->groupBy('invoice_details.productID')
                ->where('invoices.status',-1)
                ->select('invoice_details.productID')
                ->addSelect(DB::raw('null as products'))
                ->havingRaw('SUM(invoice_details.quantity) > 10')
                ->get();
               
            $array = array();
            foreach($data as $item){
                $item->products= DB::table('products')->where('id',$item->productID)
                ->select('products.*')
                ->addSelect(DB::raw('null as reviews'))
                ->addSelect(DB::raw('null as checkFavorite'))
                ->get();
                foreach ($item->products as $key ) {
                    $array[] = $key;
                    $key->checkFavorite=  DB::table('favorites')
                    ->join('favorite_details','favorites.id','favorite_details.favoriteID')
                     ->where('favorite_details.productID',$key->id)->exists();
                     $key->reviews = DB::table('reviews')
                     ->join('users','reviews.userID','=','users.id')
                     ->where('reviews.productID',$key->id)
                     ->orderBy('reviews.postedDate','desc')
                     ->select('reviews.*','users.fullName','users.avatar')
                     ->get();
                }
            }
            return  json_encode(
                $array
            );  
    }

    public function Search(Request $request,$userID){
     
        $data = DB::table('products')
        ->where('name','LIKE','%'.$request->keyword.'%')
        ->select('products.*')
        ->addSelect(DB::raw('null as checkFavorite,null as reviews'))
        ->get();
        foreach($data as $item){
            $item->checkFavorite=  DB::table('favorites')
            ->join('favorite_details','favorites.id','favorite_details.favoriteID')
            ->where('favorites.userID',$userID)
             ->where('favorite_details.productID',$item->id)->exists();
             $item->reviews = DB::table('reviews')
             ->join('users','reviews.userID','=','users.id')
             ->where('reviews.status',1)
             ->where('reviews.productID',$item->id)
             ->orderBy('reviews.postedDate','desc')
             ->select('reviews.*','users.fullName','users.avatar')
             ->get();
            
         }
        return response()->json($data);
    }

    public function Filter($userID,Request $request){
        if(!empty($request->priceSecond)){
            $data = DB::table('products')
            ->where('status',1)
            ->where('type',$request->type)
            ->whereBetween('price',[50000,100000])
            ->select('products.*')
            ->where('products.stock','>',0)
            ->orderBy('products.id','asc')
            ->addSelect(DB::raw('null as checkFavorite,null as reviews'))
            ->take(8)
            ->get();
        }else if($request->price ==50000){
            $data = DB::table('products')
            ->where('status',1)
            ->where('type',$request->type)
            ->where('price','<=',50000)
            ->select('products.*')
            ->where('products.stock','>',0)
            ->orderBy('products.id','asc')
            ->addSelect(DB::raw('null as checkFavorite,null as reviews'))
            ->take(8)
            ->get();
          
        }else{
            $data = DB::table('products')
            ->where('status',1)
            ->where('type',$request->type)
            ->where('price','>=',100000)
            ->select('products.*')
            ->where('products.stock','>',0)
            ->orderBy('products.id','asc')
            ->addSelect(DB::raw('null as checkFavorite,null as reviews'))
            ->take(8)
            ->get();
        }     
        foreach($data as $item){
           $item->checkFavorite=  DB::table('favorites')
           ->join('favorite_details','favorites.id','favorite_details.favoriteID')
           ->where('favorites.userID',$userID)
            ->where('favorite_details.productID',$item->id)->exists();
            $item->reviews = DB::table('reviews')
            ->join('users','reviews.userID','users.id')
            ->where('reviews.status',1)
            ->where('reviews.productID',$item->id)
            ->orderBy('reviews.postedDate','desc')
            ->select('reviews.*','users.fullName','users.avatar')
            ->get();          
        }    
        return json_encode(
            $data,
        );
    }
}