<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class Games extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  public $table = "games";
  public static function filterList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['games_name'])) {
      $cond .= " AND games.name LIKE '%" . $data['games_name'] . "%'";
    }

    if (!empty($data['category_id'])) {
      $cond .= " AND games.category_id='" . $data['category_id'] . "'";
    }


    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND games.status IN({$st})";
    $cond .= " ORDER BY games.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT games.*,category.category_name FROM `games` 
              LEFT JOIN category ON (category.category_id=games.category_id) 
              WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `games` WHERE 1 {$cond}";
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
