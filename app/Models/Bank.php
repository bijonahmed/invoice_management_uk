<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class Bank extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  
  
  public static function checkBankRow($id)
  {
    $row =  DB::table('bank')->where('id', $id)->first();
    return $row;
  }
 
  public static function bankfilter($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['bank_name'])) {
      $cond .= " AND bank.bank_name LIKE '%" . $data['bank_name'] . "%'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND bank.status IN({$st})";
    $cond .= " ORDER BY bank.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT bank.id,bank.bank_name,bank.status,countries.name as country_name FROM `bank`
            LEFT JOIN countries ON (countries.id=bank.country_id)
            WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `bank` WHERE 1 {$cond}";
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
