<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class NotificationController extends Controller
{
    public function loadNotification(){
        $get =  DB::table('notifications')
        ->orderBy('dateCreated','desc')
        ->get();
        return response()->json($get);
    }
}
