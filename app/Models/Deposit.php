<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class Deposit extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  public $table = "deposit";
  protected $fillable = [
    'user_id',
    'payment_method',
    'amount',
    'status',
    'created_at',
    'updated_at',
  ];
  public static function addEditCategory($request)
  {
    $data['category_name']  = !empty($request['category_name']) ? $request['category_name'] : "";
    $data['status']         = !empty($request['status']) ? (int)$request['status'] : 0;
    $data['type']           = !empty($request['type']) ? (int)$request['type'] : 0;
    $data['order_id']       = !empty($request['order_id']) ? $request['order_id'] : "";
    $data['slug']           = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['category_name'])));
    $hsdata['has_tag_name'] = $data['category_name'];
    $hsdata['status']       = $data['status'];
    $hsdata['slug']         = $data['slug'];
    if (!empty($request['category_id'])) {
      DB::table('category')->where('category_id', $request['category_id'])->update($data);
    } else {
      DB::table('category')->insert($data);
      DB::table('has_tag')->insert($hsdata);
    }
    return $data;
 
  }
  
  public static function chkSubCategory($id)
  {
    $row =  DB::table('sub_category')->where('category_id', $id)->get();
    return $row;
  }
  
  public static function filterDepositList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['username'])) {
      $cond .= " AND users.username LIKE '%" . $data['username'] . "%'";
    }
    $st = '0,1,2';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND deposit.status IN({$st})";
    $cond .= " ORDER BY deposit.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT deposit.*,users.email,users.name,countries.sortname,users.username,bank.bank_name
              FROM `deposit` 
              LEFT JOIN users ON (users.id=deposit.user_id) 
              LEFT JOIN countries ON (countries.id=deposit.country_id) 
              LEFT JOIN bank ON (bank.id=deposit.bank_id) 
              WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `deposit` LEFT JOIN users ON (users.id=deposit.user_id)  WHERE 1 {$cond}";
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
