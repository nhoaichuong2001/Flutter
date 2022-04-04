<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Response;
class ProductController extends Controller
{
    public function loadProduct(){

            $data =DB::table('products')
            ->orderBy('id','desc')
            ->get();
            $type = DB::table('products')
            ->select('products.type')->groupBy('products.type')->distinct()->get();
          
            return view('admin.products.index',compact('data','type'));
    }
    public function handleRequestSwap($request){
            if($request == 'price_up'){
                $data =DB::table('products')
                ->where('price','>=','50000')->paginate(4);
                return view('admin.products.index',compact('data'));
            }else if($request == 'price_down'){
                $data =DB::table('products')
                ->where('price','<=','50000')->paginate(4);
                return view('admin.products.index',compact('data'));
            } else if($request == 'stock'){
                $data = Product::orderBy('stock')->paginate(4);
                return view('admin.products.index',compact('data'));
            }
    }
    public function viewCreate(){
        $data =DB::table('products')->select('type')->distinct()->get();
        return view('admin.products.create',compact('data'));
    }
    
    public function createProduct(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'required',
            'type' => 'required',
            'unit' => 'required',
            'description' => 'required',
            'status' => 'required',         
        ]);
        $products =Product::create($data);
        return Response::json($products);
    }

    public function deleteProduct(Request $request){
        $products = Product::find($request->id);
        if($products !=null){
            $products->delete();
            $list = Product::All();
            return Response::json($list);
        }
    }

    public function Search(Request $request){
        if(isset($_GET['keyWord'])){
            $searchText = $_GET['keyWord'];
            $data = DB::table('products')->where('name','LIKE','%'.$searchText.'%')->paginate(2);
            $data ->appends($request->all());
            return view('admin.products.index',compact('data'));
        }else{
            return view('admin.dashboard');
        }
    }

  
}