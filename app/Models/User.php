<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  protected $fillable = [
    'name',
    'email',
    'show_password',
    'password',
  ];
  protected $hidden = [
    'password',
    'remember_token',
  ];
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
  public static function addEditRole($request)
  {
    $data['name'] = !empty($request['name']) ? $request['name'] : "";
    $data['remarks'] = !empty($request['remarks']) ? $request['remarks'] : "";
    $data['status'] = !empty($request['status']) ? (int) $request['status'] : 0;
    if (!empty($request['role_id'])) {
      DB::table('rule')->where('role_id', $request['role_id'])->update($data);
      $response = "Udpate";
      return $response;
    } else {
      DB::table('rule')->insert($data);
      $response = "Save";
      return $response;
    }
  }
  public static function approvedkyc($request)
  {
    $data['status'] = 1;
    DB::table('kyc')->where('kyc_id', $request['id'])->update($data);
    return $data;
    ;
  }
  public static function getUsersList()
  {
    $result = DB::table('users')->where('status', 1)->get();
    return $result;
  }
  public static function company()
  {
    $result = DB::table('company_setting')->first();
    return $result;
  }
  public static function getHost()
  {
    $result = DB::table('users')->where('role_id', 6)->where('status', 1)->get();
    return $result;
  }
  public static function getRoleList()
  {
    $result = DB::table('rule')->get();
    return $result;
  }
  public static function checkUserRow($id)
  {
    $result = DB::table('users')->where('id', $id)->first();
    return $result;
  }
  public static function checkCustomerRow($data)
  {
    $result = DB::table('customer')->where('phone', $data)->first();
    return $result;
  }
  public static function filterip($ip)
  {
    $result = DB::table('users')->where('register_ip', $ip)->get();
    return $result;
  }
  public static function checkAdsRow($id)
  {
    $result = DB::table('ads')->where('id', $id)->first();
    return $result;
  }
  public static function checkRoleRow($id)
  {
    $result = DB::table('rule')->where('role_id', $id)->first();
    return $result;
  }
  public static function filterLogActivity($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['user_id'])) {
      $cond .= " AND log_activities.user_id='" . $data['user_id'] . "'";
    }
    if (!empty($data['method'])) {
      $cond .= " AND log_activities.method='" . $data['method'] . "'";
    }
    $cond .= " ORDER BY log_activities.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT  log_activities.*,users.name,users.company FROM `log_activities` 
             LEFT JOIN users ON (users.id=log_activities.user_id) WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    // echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM log_activities WHERE 1 {$cond}";
    $total = DB::select($sqlt)[0]->total;
    $res = [
      "draw" => $data['draw'],
      "recordsTotal" => $total,
      "recordsFiltered" => $total,
      "data" => $results,
      'get' => $data
    ];
    return $res;
  }
  public static function fillterSchedule($data = array())
  {
    $sql = "SELECT * FROM `video_post` WHERE user_id={$data['user_id']} AND schedule_date>=NOW()";
    $result = DB::select($sql);
    return $result;
  }
  public static function filterMemberQquery($data = array())
  {
    // dd($data);
    $cond = '';
    if (!empty($data['email'])) {
      $cond .= " AND users.email LIKE '%" . $data['email'] . "%'";
    }
    $fdate = date("Y-m-d", strtotime($data['frm_date']));
    $tdate = date("Y-m-d", strtotime($data['to_date']));
    if (!empty($fdate) && !empty($tdate)) {
      $cond .= " AND DATE(created_at) BETWEEN '$fdate' AND '$tdate' ";
    }
    if (!empty($data['ip'])) {
      $cond .= " AND users.register_ip='" . $data['ip'] . "'";
    }
    if (!empty($data['username'])) {
      $cond .= " AND users.username='" . $data['username'] . "'";
    }
    if (!empty($data['phone'])) {
      $cond .= " AND users.contact='" . $data['phone'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND users.status IN({$st})";
    $cond .= " AND users.role_id=6";
    $cond .= " ORDER BY users.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT  * FROM `users`  WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM users  WHERE 1 {$cond}";
    $total = DB::select($sqlt)[0]->total;
    $res = [
      "draw" => $data['draw'],
      "recordsTotal" => $total,
      "recordsFiltered" => $total,
      "data" => $results,
      'get' => $data
    ];
    return $res;
  }
  public static function filterkycquery($data = array())
  {
    // dd($data);
    $cond = '';
    if (!empty($data['username'])) {
      $cond .= " AND users.username='" . $data['username'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND kyc.status IN({$st})";
    $cond .= " ORDER BY kyc.kyc_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT  kyc.*,users.username,countries.name as countryname FROM `kyc` 
    LEFT JOIN users ON (users.id=kyc.user_id)
    LEFT JOIN countries ON (countries.id=kyc.country_id)
    WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total,kyc.* FROM kyc LEFT JOIN users ON (users.id=kyc.user_id) 
     LEFT JOIN countries ON (countries.id=kyc.country_id)
    WHERE 1 {$cond}";
    $total = DB::select($sqlt)[0]->total;
    $res = [
      "draw" => $data['draw'],
      "recordsTotal" => $total,
      "recordsFiltered" => $total,
      "data" => $results,
      'get' => $data
    ];
    return $res;
  }
  public static function filterUserQquery($data = array())
  {
    // dd($data);
    $cond = '';
    if (!empty($data['email'])) {
      $cond .= " AND users.email LIKE '%" . $data['email'] . "%'";
    }
    // $fdate = date("Y-m-d", strtotime($data['frm_date']));
    // $tdate = date("Y-m-d", strtotime($data['to_date']));
    // if (!empty($fdate) && !empty($tdate)) {
    //   $cond .= " AND DATE(created_at) BETWEEN '$fdate' AND '$tdate' ";
    // }
    if (!empty($data['role_id'])) {
      $cond .= " AND users.role_id='" . $data['role_id'] . "'";
    }
    if (!empty($data['username'])) {
      $cond .= " AND users.username='" . $data['username'] . "'";
    }
    if (!empty($data['phone'])) {
      $cond .= " AND users.contact='" . $data['phone'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND users.status IN({$st})";
    $cond .= " ORDER BY users.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT  users.*,rule.name as rule_name FROM `users` LEFT JOIN rule ON (rule.role_id=users.role_id) WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total,users.*,rule.name as rule_name FROM users LEFT JOIN rule ON (rule.role_id=users.role_id) WHERE 1 {$cond}";
    $total = DB::select($sqlt)[0]->total;
    $res = [
      "draw" => $data['draw'],
      "recordsTotal" => $total,
      "recordsFiltered" => $total,
      "data" => $results,
      'get' => $data
    ];
    return $res;
  }
}