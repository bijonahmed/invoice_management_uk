<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
use File;
class UserController extends Controller
{
    protected $frontend_url;
    public function __construct(Request $request)
    {
        $this->frontend_url = "https://fgames.futuregenit.com/";
    }
  public function insertkyc(Request $request)
    {
       // dd($request->all());
        if (!empty($request->file('file'))) {
            $files = $request->file('file');
            $fileName = Str::random(20);
            $ext = strtolower($files->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $files->move(public_path('/backend/files/'), $upload_url);
            $file_url = $uploadPath . $path;
        } 
        $authId = (int) Auth::user()->id;
        $data = array(
            'user_id' => $authId,
            'remarks' => !empty($request->remarks) ? $request->remarks : "",
            'file'    => !empty($file_url) ? $file_url :"",
            'status'  => 0,
        );
        DB::table('kyc')->insertGetId($data);
        $response = [
            'message' => 'KYC Sending successfully done:',
        ];
        return response()->json($response, 200);
    }
    public function saveRole(Request $request)
    {
        $data = User::addEditRole($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getUsersList(Request $request)
    {
        $data = User::getUsersList($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getRoleList(Request $request)
    {
        $data = User::getRoleList($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function approvedKyc(Request $request){
        $data = User::approvedkyc($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
   public function getKycData(Request $request)
    {
       $users = User::filterkycquery($request->all());
       //list
       $data = array();
       foreach ($users['data'] as $key => $v) {
           if ($v->status == 0) {
               $sdata['status'] = '<span class="badge bg-danger">Pending</span></span>';
           } elseif ($v->status == 1) {
               $sdata['status'] = '<span class="badge bg-success">Approved</span></span>';
           }
           $sdata['username']      = !empty($v->username) ? $v->username : '-';
          // $url = url($v->file);
          // $link ="<a href='".$url."' target='_blank'>Link</a>";
           $url = "https://easy2trade.us/";

           $f_pages_img = $url.$v->f_pages_img; 
           $b_pages_img = $url.$v->b_pages_img; 
           $hold_pages_img = $url.$v->hold_pages_img; 

           $sdata['id']            = $v->kyc_id; 
           $sdata['person_name']   = $v->person_name; 
           $sdata['countryname']   = $v->countryname; 
           $sdata['id_passport']   = $v->id_passport; 
           $sdata['f_pages_img']   = "<img style='height:150px; width: 150px;' src='{$f_pages_img}'>";  
           $sdata['b_pages_img']   = "<img style='height:150px; width: 150px;' src='{$b_pages_img}'>"; 
           $sdata['hold_pages_img']= "<img style='height:150px; width: 150px;' src='{$hold_pages_img}'>";
           //$sdata['file']          = !empty($v->file) ? $link : "--"; 
           $sdata['created_at']    = !empty($v->created_at) ? $v->created_at : '-';
           $sdata['actions']          = Helper::sprint('<button class="del" data-id="{kyc_id}"><i class="fas fa-edit"></i></button>', $v);
           $data[] = $sdata;
       }
       $users['data'] = $data;
       return response()->json($users, 200);
    }
    public function AllUsersList(Request $request)
    {
        $data = User::getHost($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editUserId($id)
    {
        $data = User::checkUserRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editAdsId($id)
    {
        $data = User::checkAdsRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function roleCheck($id)
    {
        $data = User::checkRoleRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }



public function customerRow($data)
    {
        $data = User::checkCustomerRow($data);
       // dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }



    
    public function checkUserDetails($id)
    {
        $data = User::checkRoleRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function searchIPfinder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ip' => 'required|ip',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $ip = $request->ip; 
        $iphistory = User::filterip($ip);
        $data = array();
        $html = "";
        $html.="<div class='table-responsive'><table class='table table-sm table-hover' border='1'>";
        $html.=" <tr>
             <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Register IP</th>
            <th>IP History</th>
            <th>Register Date</th>
            <th>Status</th>
          </tr>";
        foreach ($iphistory as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            if(!empty($v->ref_by)){
                $chkUpline =  DB::table('users')->select('username')->where('id', $v->ref_by)->first();
            }
            $ipfilter =  DB::table('users')->select('username')->where('register_ip', $v->register_ip)->count();
            $sdata['id']            = !empty($v->id) ? $v->id : '-';
            $sdata['name']          = !empty($v->name) ? $v->name : '-';
            $sdata['username']      = !empty($v->username) ? $v->username : '-';
            $sdata['email']         = !empty($v->email) ? $v->email : '-';
            $sdata['ip_tracking']   = !empty($v->ip_tracking) ? $v->ip_tracking : '-';
            if($ipfilter>1){
                $sdata['register_ip']   = !empty($v->register_ip) ? "<strong><p style='color:red;'>".$v->register_ip."</p><strong>" : '-';
            }else{
                $sdata['register_ip']   = !empty($v->register_ip) ? $v->register_ip : '-';
            }
            $sdata['ip_tracking']   = !empty($v->ip_tracking) ? $v->ip_tracking : '-';
            $sdata['ref_by']        = !empty($chkUpline) ? $chkUpline->username : '-';
            $sdata['show_password'] = !empty($v->show_password) ? $v->show_password : '-';
            $sdata['created_at']    = !empty($v->created_at) ? $v->created_at : '-';
            $html .= Helper::sprint(' <tr>
                <th>{id}</th>
                <td>{username}</td>
                <td>{show_password}</td>
                <td>{register_ip}</td>
                <td>{ip_tracking}</td>
                <td>{created_at}</td>
                <td>{status}</td>
                </tr>', $sdata);
        }
        $html.="</table></div>";
      //  $users['data'] = $data;
      //echo $html;
     return response()->json($html, 200);
    }
    public function getLogActivity(Request $request)
    {
        $users = User::filterLogActivity($request->all());
        // dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            $sdata['name'] = !empty($v->name) ? $v->name : '-';
            $sdata['created_at'] = !empty($v->created_at) ? $v->created_at : '-';
            $sdata['url'] = !empty($v->url) ? $v->url : '-';
            $sdata['ip'] = !empty($v->ip) ? $v->ip : '-';
            $sdata['agent'] = !empty($v->agent) ? $v->agent : '-';
            $sdata['method'] = !empty($v->method) ? $v->method : '-';
            //$sdata['actions']          = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getActiveHostList()
    {
        $data = User::getHost();
        //dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getMemberData(Request $request)
    {
        $users = User::filterMemberQquery($request->all());
        // dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            if(!empty($v->ref_by)){
                $chkUpline =  DB::table('users')->select('username')->where('id', $v->ref_by)->first();
            }
            $ipfilter =  DB::table('users')->select('username')->where('register_ip', $v->register_ip)->count();
            $sdata['id']            = !empty($v->id) ? $v->id : '-';
            $sdata['name']          = !empty($v->name) ? $v->name : '-';
            $sdata['username']      = !empty($v->username) ? $v->username : '-';
            $sdata['email']         = !empty($v->email) ? $v->email : '-';
            if($ipfilter>1){
                $sdata['register_ip']   = !empty($v->register_ip) ? "<strong><p style='color:red;'>".$v->register_ip."</p><strong>" : '-';
            }else{
                $sdata['register_ip']   = !empty($v->register_ip) ? $v->register_ip : '-';
            }
            $sdata['ip_tracking']   = !empty($v->ip_tracking) ? $v->ip_tracking : '-';
            $sdata['ref_by']        = !empty($chkUpline) ? $chkUpline->username : '-';
            $sdata['show_password'] = !empty($v->show_password) ? $v->show_password : '-';
            $sdata['created_at']    = !empty($v->created_at) ? $v->created_at : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button>', $v);
            //$sdata['actions'] = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getUsersData(Request $request)
    {
        $users = User::filterUserQquery($request->all());
        $setting = User::company();
        // dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['id']            = !empty($v->id) ? $v->id : '-';
            $sdata['name']          = !empty($v->name) ? $v->name : '-';
            $sdata['rule_name']     = !empty($v->rule_name) ? $v->rule_name : '-';
            $sdata['balance']       = !empty($v->balance) ? "{$setting->currency}".$v->balance : '-';
            $sdata['email']         = !empty($v->email) ? $v->email : '-';
            $sdata['username']      = !empty($v->username) ? $v->username : '-';
            $sdata['show_password'] = !empty($v->show_password) ? $v->show_password : '-';
            $sdata['register_ip']   = !empty($v->register_ip) ? $v->register_ip : '-';
            if (!empty($v->image)) {
            } else {
                $sdata['image'] = Helper::sprint('<img src="/public/backend/blank_profile.png">', $v);
            }
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button>', $v);
            //$sdata['actions'] = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'name'    => 'required',
            'contact' => 'required',
            'email'   => 'required|email',
            'password'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        if (!empty($request->file('file'))) {
            $files = $request->file('file');
            $fileName = Str::random(20);
            $ext = strtolower($files->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $files->move(public_path('/backend/files/'), $upload_url);
            $file_url = $uploadPath . $path;
        } else {
            if (!empty($request->user_id)) {
                if (!empty($request->file('file'))) {
                    $files = $request->file('file');
                    $fileName = Str::random(20);
                    $ext = strtolower($files->getClientOriginalExtension());
                    $path = $fileName . '.' . $ext;
                    $uploadPath = '';
                    $upload_url = $uploadPath . $path;
                    $files->move(public_path('/backend/files/'), $upload_url);
                    //END 
                } else {
                    $row = DB::table('users')->where('id', $request->user_id)->first();
                    $file_url = !empty($row->image) ? $row->image : "";
                }
            } else {
                $file_url = "";
            }
        }
        $data = array(
            'role_id' => !empty($request->role_id) ? $request->role_id : "",
            'name'    => !empty($request->name) ? $request->name : "",
            'slug'    => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name))),
            'contact' => !empty($request->contact) ? $request->contact : "",
            'email'   => !empty($request->email) ? $request->email : "",
            'password'=> !empty($request->password) ? Hash::make($request->password) : "",
            'image'   => $file_url,
            'status'  => !empty($request->status) ? $request->status : 1,
        );
        if (empty($request->user_id)) {
            $userId = DB::table('users')->insertGetId($data);
        } else {
            $userId = $request->user_id;
            DB::table('users')->where('id', $request->user_id)->update($data);
        }
        $response = [
            'message' => 'User register successfully insert UserID:' . $userId
        ];
        return response()->json($response);
    }
    public function updateUser(Request $request){
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'name'    => 'required',
            'contact' => 'required',
            'email'   => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        if (!empty($request->file('file'))) {
            $files = $request->file('file');
            $fileName = Str::random(20);
            $ext = strtolower($files->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $files->move(public_path('/backend/files/'), $upload_url);
            $file_url = $uploadPath . $path;
        } else {
            if (!empty($request->user_id)) {
                if (!empty($request->file('file'))) {
                    $files = $request->file('file');
                    $fileName = Str::random(20);
                    $ext = strtolower($files->getClientOriginalExtension());
                    $path = $fileName . '.' . $ext;
                    $uploadPath = '';
                    $upload_url = $uploadPath . $path;
                    $files->move(public_path('/backend/files/'), $upload_url);
                    //END 
                } else {
                    $row = DB::table('users')->where('id', $request->user_id)->first();
                    $file_url = !empty($row->image) ? $row->image : "";
                }
            } else {
                $file_url = "";
            }
        }
        $data = array(
            'role_id' => !empty($request->role_id) ? $request->role_id : "",
            'name'    => !empty($request->name) ? $request->name : "",
            'slug'    => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name))),
            'contact' => !empty($request->contact) ? $request->contact : "",
            'email'   => !empty($request->email) ? $request->email : "",
            'image'   => $file_url,
            'status'  => !empty($request->status) ? $request->status : "",
        );
        if (!empty($request->user_id)) {
            $userId = $request->user_id;
            DB::table('users')->where('id', $request->user_id)->update($data);
        }  
        $response = [
            'message' => 'User register successfully update UserID:' . $userId
        ];
        return response()->json($response);
    }
}