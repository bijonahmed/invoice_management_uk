<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
class ProfileController extends Controller
{
    public function getcountryList()
    {
        $rows = Profile::country();
        $response = [
            'data' => $rows,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:1|confirmed',
            'password_confirmation' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $user = Auth::user();
        // if (!Hash::check($request->currentpassword, $user->password)) {
        //     $response = "Current password does not match!";
        //     return response()->json($response);
        // }
        $user->password      = Hash::make($request->password);
        $user->show_password = $request->password;
        $user->save();
       
        $response = "Password successfully changed!";
        return response()->json($response);
    }

    public function updateUserPassword(Request $request){

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:1|confirmed',
            'password_confirmation' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $id= (int)$request->user_id;
        $user = User::find($id);
        //dd($currentuser->username);
        $user->password      = Hash::make($request->password);
        $user->show_password = $request->password;
        $user->save();
       
        $response = "Password successfully changed!";
        return response()->json($response);


    }







    public function checkEmail(Request $request)
    {
        $row = DB::table('users')->where('email', $request->email)->first();
        if (empty($row)) {
            $data['status'] = 0; //no user; 
        } else {
            $data['status'] = 1; //no user; 
        }
        return response()->json($data);
    }
    public function checkPhone(Request $request)
    {
        $row = DB::table('users')->where('contact', $request->phone)->first();
        if (empty($row)) {
            $data['status'] = 0; //no user; 
        } else {
            $data['status'] = 1; //no user; 
        }
        return response()->json($data);
    }
    public function removeUser(Request $request)
    {
        $data['id'] = $request->id;
        $data['status'] = 3;
        DB::table('users')->where('id', $request->id)->update($data);
    }
    public function updateprofile(Request $request)
    {
        if (!empty($request->file('file'))) {
            $documents = $request->file('file');
            $fileName = Str::random(20);
            $ext = strtolower($documents->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $documents->move(public_path('/backend/files/'), $upload_url);
        } else {
            $image = Auth::user()->image;
        }
        $authId = (int) Auth::user()->id;
        $data = array(
            'id' => $authId,
            'image' => !empty($upload_url) ? $upload_url : $image,
            'name' => !empty($request->name) ? $request->name : "",
            'email' => !empty($request->email) ? $request->email : "",
            'company' => !empty($request->company) ? $request->company : "",
            'contact' => !empty($request->contact) ? $request->contact : "",
            'country' => !empty($request->country_id) ? $request->country_id : "",
            'address' => !empty($request->address) ? $request->address : "",
        );
        DB::table('users')->where('id', $authId)->update($data);
        $response = [
            'imagelink' => !empty($upload_url) ? $upload_url : $image,
            'message' => 'User register successfully update'
        ];
        return response()->json($response);
    }
    public function updateCompanySetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'email' => 'required|string|min:1',
            'address' => 'required',
            'hotline' => 'required',
            'emergency' => 'required',
            'fblink' => 'required',
            'twitterlink' => 'required',
            'linkdinlink' => 'required',
            'crypto_wallet_address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $row = Profile::companySetting();
        if (!empty($request->file('file'))) {
            $documents = $request->file('file');
            $fileName = Str::random(20);
            $ext = strtolower($documents->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $documents->move(public_path('/backend/files/'), $upload_url);
        } else {
            $image = $row->logo;
        }
        $id = 1;
        $data = array(
            'setting_id'        => $id,
            'logo'              => !empty($upload_url) ? $upload_url : $image,
            'company_name'      => !empty($request->company_name) ? $request->company_name : "",
            'email'             => !empty($request->email) ? $request->email : "",
            'address'           => !empty($request->address) ? $request->address : "",
            'hotline'           => !empty($request->hotline) ? $request->hotline : "",
            'emergency'         => !empty($request->emergency) ? $request->emergency : "",
            'fblink'            => !empty($request->fblink) ? $request->fblink : "",
            'twitterlink'       => !empty($request->twitterlink) ? $request->twitterlink : "",
            'tel'               => !empty($request->tel) ? $request->tel : "",
            'linkdinlink'       => !empty($request->linkdinlink) ? $request->linkdinlink : "",
            'crypto_wallet_address' => !empty($request->crypto_wallet_address) ? $request->crypto_wallet_address : "",
            'min_deposit'         => !empty($request->min_deposit) ? $request->min_deposit : "",
            'max_deposit'         => !empty($request->max_deposit) ? $request->max_deposit : "",
            'min_withdraw'        => !empty($request->min_withdraw) ? $request->min_withdraw : "",
            'max_withdraw'        => !empty($request->max_withdraw) ? $request->max_withdraw : "",
            'min_trade_amount'    => !empty($request->min_trade_amount) ? $request->min_trade_amount : "",
            'mining_profit'       => !empty($request->mining_profit) ? $request->mining_profit : "",
            'mining_duration'     => !empty($request->mining_duration) ? $request->mining_duration : "",
            'upline_comission'    => !empty($request->upline_comission) ? $request->upline_comission : "",
            'trade_percent'       => !empty($request->trade_percent) ? $request->trade_percent : "",
            'trade_fee'       => !empty($request->trade_fee) ? $request->trade_fee : "",

            'country_id' => !empty($request->country_id) ? $request->country_id : "",
        );
        //dd($data);
        DB::table('company_setting')->where('setting_id', $id)->update($data);
        $response = [
            'imagelink' => !empty($upload_url) ? $upload_url : $image,
            'message' => 'User register successfully update'
        ];
        return response()->json($response);
    }
    public function getCompanySetting()
    {
        $rows = Profile::companySetting();
        $response = [
            'data' => $rows,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}