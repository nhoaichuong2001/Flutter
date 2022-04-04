<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class VoucherController extends Controller
{
   public function ShowVoucher(){
       $currentDate = Date('Y-m-d');
       $vouchers = DB::table('vouchers')
       ->where('limit','>',0)
       ->whereDate('endDate','>=',$currentDate)
       ->get(); 
       return response()->json($vouchers);
   }
   
}
