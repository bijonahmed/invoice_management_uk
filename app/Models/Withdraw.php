<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class Withdraw extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  public $table = "withdrawal";
  protected $fillable = [
    'user_id',
    'amount',
    'status',
    'created_at',
    'updated_at',
  ];
 
  
  public static function filter($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['username'])) {
      // $cond .= " AND users.username LIKE '%" . $data['username'] . "%'";
      $cond .= " AND users.username LIKE '" . $data['username'] . "'";
    }
    $st = '0,1,2';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND withdrawal.status IN({$st})";
    $cond .= " ORDER BY withdrawal.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT withdrawal.*,users.username,users.name
              FROM `withdrawal` 
              LEFT JOIN users ON (users.id=withdrawal.user_id) 
              WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `withdrawal` LEFT JOIN users ON (users.id=withdrawal.user_id)  WHERE 1 {$cond}";
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
