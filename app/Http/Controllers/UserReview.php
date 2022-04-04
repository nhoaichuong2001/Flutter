<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserReview extends Controller
{
    public function Post(Request $request){ 
       
            DB::table('reviews')
            ->insert([
                'userID' =>$request->userID,
                'productID' =>$request->productID,
                'content' =>$request->content,
                'quantity' =>$request->quantity,
                'postedDate' =>Date('Y-m-d H:i:s'),
                'status' =>1,
            ]);
             
        return response()->json(["success"=>"Tạo bài đăng thành công"]);
    }
}
