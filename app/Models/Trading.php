<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class Trading extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  public $table = "trading";
  protected $fillable = [
    'user_id',
    'payment_method',
    'amount',
    'status',
    'created_at',
    'updated_at',
  ];
  
  
  public static function chkSubCategory($id)
  {
    $row =  DB::table('sub_category')->where('category_id', $id)->get();
    return $row;
  }
   
public static function filterMiningList($data = array())
  {

    $cond = '';
    if (!empty($data['username'])) {
      $cond .= " AND users.username LIKE '%" . $data['username'] . "%'";
    }
 
    $st = '0,1,2';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND mining.status IN({$st})";
    $cond .= " ORDER BY mining.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT mining.*,users.email,users.name,users.username,DATE_ADD(mining.`created_at`, INTERVAL `diff_hour` hour) AS ending_time FROM `mining`
     LEFT JOIN users ON (users.id=mining.user_id) WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
  //  echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `mining` LEFT JOIN users ON (users.id=mining.user_id)  WHERE 1 {$cond}";
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
 

  public static function filterCryptohistoryList($data = array()){

    $cond = '';
    // if (!empty($data['username'])) {
    //   $cond .= " AND users.username LIKE '%" . $data['username'] . "%'";
    // }
 
    $st = '0,1,2';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND compay_crypto_wallet.status IN({$st})";
    $cond .= " ORDER BY compay_crypto_wallet.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `compay_crypto_wallet` WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
  //  echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `compay_crypto_wallet`  WHERE 1 {$cond}";
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






  
  public static function filterTradingList($data = array())
  {
 
    $cond = '';
    if (!empty($data['username'])) {
      $cond .= " AND users.username LIKE '%" . $data['username'] . "%'";
    }

    if (!empty($data['trade_id'])) {
      $cond .= " AND trading.trade_id='" . $data['trade_id'] . "'";
    }

    $st = '0,1,2';
    if (isset($data['status'])) {
      $st = $data['status'];
 
    }
    $cond .= " AND trading.status IN({$st})";
    $cond .= " ORDER BY trading.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT trading.*,users.email,users.name,users.username FROM `trading` LEFT JOIN users ON (users.id=trading.user_id) WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
  //  echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `trading` LEFT JOIN users ON (users.id=trading.user_id)  WHERE 1 {$cond}";
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
