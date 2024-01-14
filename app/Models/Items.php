<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use Auth;
use DB;
class Items extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  public $table = "lead";
  public static function addEditItem($request)
  {
    $data['item_id']     = !empty($request['item_id']) ? $request['item_id'] : "";
    $data['item_name']   = !empty($request['item_name']) ? $request['item_name'] : "";
    $data['unit_price']  = !empty($request['unit_price']) ? $request['unit_price'] : "";
    $data['unit']        = !empty($request['unit']) ? $request['unit'] : "";
    $data['user_id']     = Auth::user()->id;
    $data['status']      = !empty($request['status']) ? (int)$request['status'] : 0;
    $data['create_at']   = date('Y-m-d H:i:s');
    $data['update_at']   = date('Y-m-d H:i:s');
    //dd($data);
    if (!empty($request['item_id'])) {
      DB::table('items')->where('item_id', $request['item_id'])->update($data);
    } else {
      DB::table('items')->insert($data);
    }
    return  $data;
  }
  public static function checkItemName($name)
  {
    $row =  DB::table('items')->where('item_name', $name)->first();
    return $row;
  }
  public static function checkItemRow($id)
  {
    $row =  DB::table('items')->where('item_id', $id)->first();
    return $row;
  }
  public static function checkItems()
  {
    return DB::table('items')->get();
  }
  public static function filterItemist($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['item_name'])) {
      $cond .= " AND items.item_name LIKE '%" . $data['item_name'] . "%'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND items.status IN({$st})";
    $cond .= " ORDER BY items.item_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `items` WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM items WHERE 1 {$cond}";
    $total = DB::select($sqlt)[0]->total;
    $res = [
      "draw"            => $data['draw'],
      "recordsTotal"    => $total,
      "recordsFiltered" => $total,
      "data"            => $results,
      'get'             => $data
    ];
    return $res;
  }
}
