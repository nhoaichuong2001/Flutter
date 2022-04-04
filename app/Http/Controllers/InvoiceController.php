<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\User;
use App\Models\Product;

class InvoiceController extends Controller
{
    function payment(Request $request,$invoiceID){
    
       
        DB::table('invoices')->where('id',$invoiceID)
        ->update([
            'shippingAddress' => $request->address,
            'total' =>$request->total,
            'status' => 1,
        ]);
        $data = DB::table('invoice_details')
        ->where('invoiceID',$invoiceID)->get();
        foreach($data as $item){
            $stock = DB::table('products')
            ->where('id',$item->productID)
            ->select('stock')->get(); 
            DB::table('products')
            ->where('id',$item->productID)
            ->update([
                'stock' => $stock[0]->stock -$item->quantity
            ]);
        }
        return response()->json([
            "Thanh toán thành công" => true
        ],200);
    }
    function getInvoiceForUser($userID){
    
        
        $checkInvoice = DB::table('invoices')
        ->where('invoices.userID',$userID)
        ->Where('invoices.status','=',-1)
      ->exists();
   
        $query = null;
        if( $checkInvoice){
            $query = DB::table('invoices')
            ->join('users','invoices.userID','=','users.id')
            ->select('invoices.*') 
            ->where('invoices.userID',$userID)
            ->Where('invoices.status','=',-1)
            ->addSelect(DB::raw("null as products"))->get();
           
        foreach( $query  as $item){
            $listProduct = DB::table('invoice_details')
            ->join('products','invoice_details.productID','=','products.id')
            ->where('invoiceID',$item->id)
            ->select('products.*','invoice_details.quantity')->get();
            $item->products = $listProduct;
        }
        }
        if($query != null){
            return json_encode(
                $query,
            );
        }else{
            return response()->json([
                "message" => false
            ],201);
        }
    }
    function getInvoiceWaitingToAccept($userID){
        $checkInvoice = DB::table('invoices')
        ->where('invoices.userID',$userID)
        ->Where('invoices.status','=',1)
      ->exists();
   
        $query = null;
        if( $checkInvoice){
            $query = DB::table('invoices')
            ->join('users','invoices.userID','=','users.id')
            ->select('invoices.*') 
            ->where('invoices.userID',$userID)
            ->Where('invoices.status','=',1)
            ->addSelect(DB::raw("null as products"))->get();
           
        foreach( $query  as $item){
            $listProduct = DB::table('invoice_details')
            ->join('products','invoice_details.productID','=','products.id')
            ->where('invoiceID',$item->id)
            ->select('products.*','invoice_details.quantity')->get();
            $item->products = $listProduct;
        }
        }
        if($query != null){
            return json_encode(
                $query,
            );
        }else{
            return response()->json([
                "message" => false
            ],201);
        }
    }

    function getInvoicePickingUpGood($userID){
        $checkInvoice = DB::table('invoices')
        ->where('invoices.userID',$userID)
        ->Where('invoices.status','=',2)
      ->exists();
   
        $query = null;
        if( $checkInvoice){
            $query = DB::table('invoices')
            ->join('users','invoices.userID','=','users.id')
            ->select('invoices.*') 
            ->where('invoices.userID',$userID)
            ->Where('invoices.status','=',2)
            ->addSelect(DB::raw("null as products"))->get();
           
            foreach( $query  as $item){
                $listProduct = DB::table('invoice_details')
                ->join('products','invoice_details.productID','=','products.id')
                ->where('invoiceID',$item->id)
                ->select('products.*','invoice_details.quantity')->get();
                $item->products = $listProduct;
            }
        }
       
        if($query != null){
            return json_encode(
                $query,
            );
        }else{
            return response()->json([
                "message" => false
            ],201);
        }
    }

    function getInvoiceOnDelivery($userID){
        $checkInvoice = DB::table('invoices')
        ->where('invoices.userID',$userID)
        ->Where('invoices.status','=',3)
      ->exists();
   
        $query = null;
        if( $checkInvoice){
            $query = DB::table('invoices')
            ->join('users','invoices.userID','=','users.id')
            ->select('invoices.*') 
            ->where('invoices.userID',$userID)
            ->Where('invoices.status','=',1)
            ->addSelect(DB::raw("null as products"))->get();
           
        foreach( $query  as $item){
            $listProduct = DB::table('invoice_details')
            ->join('products','invoice_details.productID','=','products.id')
            ->where('invoiceID',$item->id)
            ->select('products.*','invoice_details.quantity')->get();
            $item->products = $listProduct;
        }
        }
        if($query != null){
            return json_encode(
                $query,
            );
        }else{
            return response()->json([
                "message" => false
            ],201);
        }
    }
    public function OrderDetails($invoiceID){
        $data = DB::table('invoices')
        ->where('invoices.id',$invoiceID)
        ->select('invoices.*')
        ->addSelect(DB::raw('null as products'))
        ->get();
        $data[0]->products = DB::table('invoice_details')
        ->join('products','invoice_details.productID','=','products.id')
        ->where('invoiceID',$data[0]->id)
        ->select('products.*','invoice_details.quantity')->get();
        return response()->json(
           $data[0]
        );

    }
    public function CancelOrder($invoiceID){
        $check = DB::table('invoices')->where('id',$invoiceID)->where('status',0);
        if(!empty($check)){
            $updateStock = DB::table('invoice_details')->where('invoiceID',$invoiceID)->select('productID','quantity')->get();
            foreach($updateStock as $item){
               $getPR =  DB::table('products')
                ->where('id',$item->productID)
                ->get();
                $stock = $item->quantity + $getPR[0]->stock;
                DB::table('products')
                ->where('id',$item->productID)
                ->update([
                    'stock' =>$stock
                ]);
            }
            DB::table('invoice_details')
            ->where('invoiceID',$invoiceID)
            ->delete();
            DB::table('invoices')
            ->where('id',$invoiceID)->delete();
            return response()->json([
                "message" => "Xóa đơn hàng thành công"
            ],200);
        }else{
            return response()->json([
                "message" => "Xin lỗi bạn đơn hàng đã chuẩn bị"
            ],201);
        }
       
       
    }
   
    
}
