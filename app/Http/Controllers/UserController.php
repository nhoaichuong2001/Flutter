<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function loadUser($id){
        $getUser = DB::table('users')
        ->where('id',$id)
        ->select('users.*')
        ->get();
        return response()->json($getUser[0]);
    }

    function register(Request $request)
    {       
        $isCheckEmail = DB::table('users')->where('email',$request->email)->exists();
        if($isCheckEmail){
            return response()->json([
                "message" => "Email đã tồn tại",
            ],201);
        }
        DB::table('users') -> insert([
            'username' => $request->username,
            'fullName' => $request->fullName,
            'email' => $request->email,
            'avatar' => "",
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 0,
        ]);
        return  json_encode([
            "message" => "Thành công",
        ]);
    }
    function editUser(Request $request,$id)
    {
        $users = DB::table('users')->where('id',$id)->get();  
        $email =  DB::table('users')->get();
        $checkEmail = false;
        foreach($email as $item){
            if($users[0]->id == $item->id){
                if($request->email == $item->email){
                    $checkEmail = true;
                }
                $checkEmail =true;
            }else{
                if($request->email == $item->email){
                    $checkEmail = false;
                }
            }
        }
      
        if($users !=null){     
            if($checkEmail ==false){
                return response()->json(
                    [
                        "message"=>"email đã tồn tại"],201);
            }
            if(empty($request->password)){
                DB::table('users')
                ->where('id',$id)
                ->update([
                    'username' => $request->username,
                    'fullName' => $request->fullName,
                    'phone' => $request->phone,
                    'email' =>$request->email,
                ]);
            }
            else{
                DB::table('users')
                ->where('id',$id)
                ->update([
                    'username' => $request->username,
                    'fullName' => $request->fullName,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]);
            }
           
            $newUser = DB::table('users')
            ->where('id',$id)
            ->select('users.*')
            ->addSelect(DB::raw('null as address'))
            ->get();                           
            foreach($newUser as $user){
                $addresses= DB::table('addresses')
                ->where('userID',$user->id)
                ->select('id','name')
                ->get();
                $user->address = $addresses;
            }
            return  json_encode($newUser[0]);  
               }       
        else{
            return  json_encode([
                "message" => "Lỗi",
                 "data" => "Sửa không thành công",
            ]);}
    }
  
    public function login(Request $request)
    {
        
        if (Auth::guard('user')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->get('remember'))) {
            $token = Str::random(length:40);
            DB::table('users')
            ->where('email',$request->email)
            ->update([
                // 'remember_token' =>  $token,
                'status' => 1
            ]);
            $users = DB::table('users')
            ->where('email',$request->email)
            ->select('users.*')
            ->addSelect(DB::raw('null as address'))
            ->get();                           
            foreach($users as $user){
                $addresses= DB::table('addresses')
                ->where('userID',$user->id)
                ->select('id','name')
                ->get();
                $user->address = $addresses;
            }
            return  json_encode(
              $users[0]
            );
        }
        return  response()->json([
            "message" => false,
        ],201);
    }

    function logout(Request $request){     
        DB::table('users')
        ->where('email',$request->email)
        ->update([
            'status' => 0
        ]); 
        Auth::guard('user')->logout();
        return  response()->json([
            "message" => true,
        ],200);
    }

    public function ForgotPassword(Request $request){
        $passwordDefault = '123';
        $check =  DB::table('users')
        ->where('email',$request->email)
        ->exists();
      
        if(!$check){
            return response()->json(['success'=>'Thất bại'],201);
        }else{
            $user = DB::table('users')
            ->where('email',$request->email)
            ->select('username')->get();
            DB::table('users')
            ->where('email',$request->email)
            ->update([
                'password' => Hash::make($user[0]->username.$passwordDefault),
            ]);
            return response()->json(['success'=>$user[0]->username.$passwordDefault],200);
        }
        
    }
}
