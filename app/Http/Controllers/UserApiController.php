<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserApiController extends Controller
{
    public function ShowUser($id=null){
    
        if($id==''){
            $users = User::get();
            return response()->json(['users' => $users], 200);
        }else{
        
            $users = User::find($id);
            return response()->json(['users' => $users], 200);
        }
    }
    
    public function AddUser(Request $request){
        if($request->ismethod('post')){
        
          $data = $request->all();
        //   return $data;
        
        $rules = [
        
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        
        ];
        
        $customMessege = [
        
            'name.required' => 'Name is Required',
            'email.required' => 'Email is Required',
            'email.email' => 'Email must be Vaild',
            'password.required' => 'Password is Required',
        ];
        
        $valid = validator::make($request->all(),$rules,$customMessege);
         if($valid->fails()){
             return response()->json($valid->errors(), 422);
        }
        
        
            
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $messege = 'User Successfully Added';
            return response()->json(['messege' => $messege], 201);
        }
    }
    
    // Post Api For Add Multi User
    public function MultiUser(Request $request){
        if($request->ismethod('post')){
        
          $data = $request->all();
        //   return $data;
        
        $rules = [
        
            'users.*.name' => 'required',
            'users.*.email' => 'required|email|unique:users',
            'users.*.password' => 'required',
        
        ];
        
        $customMessege = [
        
            'users.*.name.required' => 'Name is Required',
            'users.*.email.required' => 'Email is Required',
            'users.*.email.email' => 'Email must be Vaild',
            'users.*.password.required' => 'Password is Required',
        ];
        
        $valid = validator::make($request->all(),$rules,$customMessege);
         if($valid->fails()){
             return response()->json($valid->errors(), 422);
        }
        
        
           foreach($data['users'] as $multiuser){
            
             
            $user = new User();
            $user->name = $multiuser['name'];
            $user->email = $multiuser['email'];
            $user->password = bcrypt($multiuser['password']);
            $user->save();
            $messege = 'User Successfully Added';
            
           
           }
           return response()->json(['messege' => $messege], 201);
           
        }
    }
    
    // Put Api For Update User
    public function UpdateUser(Request $request,$id){
        if($request->ismethod('put')){
        
          $data = $request->all();
        //   return $data;
        
        $rules = [
        
            'name' => 'required',
            'password' => 'required',
        
        ];
        
        $customMessege = [
        
            'name.required' => 'Name is Required',
            'password.required' => 'Password is Required',
        ];
        
        $valid = validator::make($request->all(),$rules,$customMessege);
         if($valid->fails()){
             return response()->json($valid->errors(), 422);
        }
        
        
            
            $user = User::findorfail($id);
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $messege = 'User Successfully Updated';
            return response()->json(['messege' => $messege], 202);
        }
    }
    
      // Patch Api For Update Single Record
      public function UpdateSingleRecord(Request $request,$id){
        if($request->ismethod('patch')){
        
          $data = $request->all();
        //   return $data;
        
        $rules = [
        
            'name' => 'required',
        ];
        
        $customMessege = [
        
            'name.required' => 'Name is Required',
        ];
        
        $valid = validator::make($request->all(),$rules,$customMessege);
         if($valid->fails()){
             return response()->json($valid->errors(), 422);
        }
        
        
            
            $user = User::findorfail($id);
            $user->name = $data['name'];
            $user->save();
            $messege = 'User Successfully Updated';
            return response()->json(['messege' => $messege], 202);
        }
    }
    
     // Delete Single User 
    public function DeleteSingleRecord($id=null){
    
        User::findOrFail($id)->delete();
        $messege = 'User Successfully Deleted';
        return response()->json(['messege' => $messege], 202);
    
    }
    
    // Delete Single User with Json
    
    public function DeleteSingleRecordWithJson(Request $request){
        
        if($request->isMethod('delete')){
        
            $data = $request-> all();
            User::where('id',$data['id'])->delete();
            $messege = 'User Successfully Deleted';
            return response()->json(['messege' => $messege], 202);
        }
    }
    
    // Delete Multiple user
    public function DeleteMultipleUser($ids){
        
        $ids = explode(',',$ids);
        User::whereIn('id',$ids)->delete();
        $messege = 'User Successfully Deleted';
        return response()->json(['messege' => $messege], 200);
    }
    
        // Delete Multiple User with Json
    
        public function DeleteMultipleRecordWithJson(Request $request){
        
            $header = $request->header('Authorization');
            if($header==''){
                $messege = 'Authorization is Required';
                return response()->json(['messege' => $messege], 422);
            }else{
                if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6Implc21pbiBha3RoZXIgbmFuY3kiLCJpYXQiOjE1MTYyMzkwMjJ9.fBaFRpgvGYjVe8QNTrR2Bb9QrQtThdIust0Iys4ak_U'){
                    if($request->isMethod('delete')){
            
                        $data = $request-> all();
                        User::whereIn('id',$data['ids'])->delete();
                        $messege = 'User Successfully Deleted';
                        return response()->json(['messege' => $messege], 422);
                    }
                }else{
                    $messege = 'Aurization is not match';
                    return response()->json(['messege' => $messege], 200);
                }
            }
        

        }
    //Register Api Using Passport
    public function RegisterUserUsingPassport(Request $request){
    
        if($request->ismethod('post')){
        
            $data = $request->all();
          //   return $data;
          
          $rules = [
          
              'name' => 'required',
              'email' => 'required|email|unique:users',
              'password' => 'required',
          
          ];
          
          $customMessege = [
          
              'name.required' => 'Name is Required',
              'email.required' => 'Email is Required',
              'email.email' => 'Email must be Vaild',
              'password.required' => 'Password is Required',
          ];
          
          $valid = validator::make($request->all(),$rules,$customMessege);
           if($valid->fails()){
               return response()->json($valid->errors(), 422);
          }
          
          
              
              $user = new User();
              $user->name = $data['name'];
              $user->email = $data['email'];
              $user->password = bcrypt($data['password']);
              $user->save();
              
                if(Auth::attempt(['email'=> $data['email'],'password'=> $data['password']])){
                
                    $user = User::where('email',$data['email'])->first();
                    $access_token = $user->createToken($data['email'])->accessToken;
                    User::where('email',$data['email'])->update(['access_token' => $access_token]);
                    $messege = 'User Successfully Registered';
                    return response()->json(['messege' => $messege,'access_token' => $access_token], 201);
                }else{
                    $messege = 'Oops! Something went wrong';
                    return response()->json(['messege' => $messege,], 422);
                
                }
              
            
          }
        
    }
    
    
    
    public function LoginUserUsingPassport(Request $request){
    
        if($request->ismethod('post')){
        
            $data = $request->all();
          //   return $data;
          
          $rules = [
              'email' => 'required|email|exists:users',
              'password' => 'required',
          
          ];
          
          $customMessege = [
              'email.required' => 'Email is Required',
              'email.email' => 'Email must be Vaild',
              'email.exists' => 'Email does not exists',
              'password.required' => 'Password is Required',
          ];
          
          $valid = validator::make($request->all(),$rules,$customMessege);
           if($valid->fails()){
               return response()->json($valid->errors(), 422);
          }
          
              
                if(Auth::attempt(['email'=> $data['email'],'password'=> $data['password']])){
                
                    $user = User::where('email',$data['email'])->first();
                    $access_token = $user->createToken($data['email'])->accessToken;
                    User::where('email',$data['email'])->update(['access_token' => $access_token]);
                    $messege = 'User Successfully Login';
                    return response()->json(['messege' => $messege,'access_token' => $access_token], 201);
                }else{
                    $messege = 'Oops! Something went wrong';
                    return response()->json(['messege' => $messege,], 422);
                
                }
              
            
          }
        
    }
    
}
