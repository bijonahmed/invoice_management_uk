<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class Post extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  public $table = "video_post";
  // public static function postVideoCategory($id)
  // {
  //   return DB::table('category_history')
  //     ->select('category.category_name', 'category_history.cat_history_id', 'category_history.category_id')
  //     ->leftJoin('category', 'category.category_id', '=', 'category_history.category_id')
  //     ->where('category_history.post_id', $id)->orderBy('category_name', 'asc')->get();
  // }
  // public static function postVideoHasTag($id)
  // {
  //   return DB::table('hastag_history')
  //     ->select('has_tag.has_tag_name', 'hastag_history.has_tag_id', 'hastag_history.htag_history_id')
  //     ->leftJoin('has_tag', 'has_tag.has_tag_id', '=', 'hastag_history.has_tag_id')
  //     ->where('hastag_history.post_id', $id)->orderBy('has_tag_name', 'asc')->get();
  // }
  // public static function checkPostRow($id)
  // {
  //   $row = DB::table('video_post')->where('post_id', $id)->first();
  //   return $row;
  // }
  // public static function checGamesRow($id)
  // {
  //   $row = DB::table('games')->where('id', $id)->first();
  //   return $row;
  // }
  public static function postLimit()
  {
    $result = DB::table('deposit')
      ->select('users.username', 'users.created_at', 'deposit.created_at', 'deposit.id', 'deposit.amount')
      ->leftJoin('users', 'users.id', '=', 'deposit.user_id')
      ->where('deposit.status', 0)->orderby('deposit.id', 'desc')->get();
    return $result;
  }
  public static function tradehistyorylist()
  {
    $result = DB::table('trading')
      ->select('users.username', 'trading.trade_price', 'trading.trade_id', 'trading.coin_code', 'trading.close_time', 'trading.status', 'trading.api_update_status', 'trading.create_at')
      ->leftJoin('users', 'users.id', '=', 'trading.user_id')->limit(150)->orderby('trading.id', 'desc')->get();
    return $result;
  }
  public static function totalTrade()
  {
    $result = DB::table('trading')->sum('trade_price');
    return $result;
  }
  public static function totalUsers()
  {
    $result = DB::table('users')->where('status', 1)->count();
    return $result;
  }
  public static function totalCustomers()
  {
    $result = DB::table('customer')->where('status', 1)->count();
    return $result;
  }
  public static function totalProfit()
  {
    $result = DB::table('invoice')->where('status', 1)->sum('profit');
    return $result;
  }
  public static function totalDue()
  {
    $result = DB::table('invoice')->where('status', 1)->sum('due_amount');
    return $result;
  }
  public static function duereport($data)
  {
    $startDate =  date('Y-m-d', strtotime($data['frm_date']));
    $endDate =  date('Y-m-d', strtotime($data['to_date']));
    $result = DB::table('invoice')
      ->select('invoice.inv_id', 'invoice.invoice_date', 'invoice.due_amount', 'customer.name as customer_name', 'users.name', 'phone')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice.customer_id')
      ->leftJoin('users', 'users.id', '=', 'invoice.entry_by')
      ->whereBetween('invoice.invoice_date', [$startDate, $endDate])
      ->get();
    return $result;
  }
  public static function duereportMoney($data)
  {
    $startDate =  date('Y-m-d', strtotime($data['frm_date']));
    $endDate =  date('Y-m-d', strtotime($data['to_date']));
    $result = DB::table('invoice_money_transfer')
      ->select('invoice_money_transfer.mone_transfer_id', 'invoice_money_transfer.invoice_date', 'invoice_money_transfer.due_amount', 'customer.name as customer_name', 'users.name', 'phone')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice_money_transfer.customer_id')
      ->leftJoin('users', 'users.id', '=', 'invoice_money_transfer.entry_by')
      ->whereBetween('invoice_money_transfer.invoice_date', [$startDate, $endDate])
      ->get();
    return $result;
  }
  public static function profitreport($data)
  {
    $startDate =  date('Y-m-d', strtotime($data['frm_date']));
    $endDate =  date('Y-m-d', strtotime($data['to_date']));
    $result = DB::table('invoice')
      ->select('invoice.customer_deposit','invoice.depart_to','invoice.vendorpnr','invoice.status','invoice.invoice_id', 'invoice.inv_id', 'invoice.created_at', 'supplier.name as supplier_name', 'invoice.due_amount', 'invoice.profit', 'customer.name as customer_name', 'users.name', 'customer_amount', 'net_amount', 'customer_deposit')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice.customer_id')
      ->leftJoin('supplier', 'supplier.sulipper_id', '=', 'invoice.sulipper_id')
      ->leftJoin('users', 'users.id', '=', 'invoice.entry_by')
      ->whereBetween('invoice.invoice_date', [$startDate, $endDate])
      ->get();
    return $result;
  }
  public static function profitreportMoney($data)
  {
    $startDate =  date('Y-m-d', strtotime($data['frm_date']));
    $endDate =  date('Y-m-d', strtotime($data['to_date']));
    $result = DB::table('invoice_money_transfer')
      ->select('invoice_money_transfer.fees','invoice_money_transfer.others_fees','invoice_money_transfer.receiving_amount','invoice_money_transfer.due_amount','invoice_money_transfer.status','supplier.name as supplier_name', 'invoice_money_transfer.customer_deposit','invoice_money_transfer.profit','invoice_money_transfer.rate','invoice_money_transfer.beneficiary_name','invoice_money_transfer.invoice_date', 'invoice_money_transfer.mone_transfer_id', 'invoice_money_transfer.create_date', 'invoice_money_transfer.profit', 'customer.name as customer_name', 'users.name', 'total_amount', 'net_amount', 'customer_deposit', 'create_date')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice_money_transfer.customer_id')
      ->leftJoin('users', 'users.id', '=', 'invoice_money_transfer.entry_by')
      ->leftJoin('supplier', 'supplier.sulipper_id', '=', 'invoice_money_transfer.sulipper_id')
      ->whereBetween('invoice_money_transfer.invoice_date', [$startDate, $endDate])
      ->get();
    return $result;
  }
  public static function profitReportOther($data)
  {
    $startDate =  date('Y-m-d', strtotime($data['frm_date']));
    $endDate =  date('Y-m-d', strtotime($data['to_date']));
    $result = DB::table('others_invoice')
      ->select('others_invoice.others_inv_id', 'others_invoice.invoice_date', 'others_invoice.profit', 'customer.name as customer_name', 'users.name', 'purpose', 'net_amount', 'customer_amount', 'amount_paid', 'profit', 'due_amount', 'create_date')
      ->leftJoin('customer', 'customer.customer_id', '=', 'others_invoice.customer_id')
      ->leftJoin('users', 'users.id', '=', 'others_invoice.entry_by')
      ->whereBetween('others_invoice.invoice_date', [$startDate, $endDate])
      ->get();
    return $result;
  }
  public static function filterLivePostList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['txtField'])) {
      $cond .= " AND video_post.title LIKE '%" . $data['txtField'] . "%'";
    }
    //category_id
    if (!empty($data['userid'])) {
      $cond .= " AND video_post.user_id='" . $data['userid'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND video_post.status IN({$st})";
    $cond .= " AND video_post.type=2";
    $cond .= " ORDER BY video_post.post_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `video_post`
      LEFT JOIN users ON (users.id=video_post.user_id)
     WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM video_post
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
  public static function filterPostList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['txtField'])) {
      $cond .= " AND video_post.title LIKE '%" . $data['txtField'] . "%'";
    }
    //category_id
    if (!empty($data['category_id'])) {
      $cond .= " AND category_history.category_id='" . $data['category_id'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND video_post.status IN({$st})";
    $cond .= " AND video_post.type=1";
    $cond .= " ORDER BY video_post.post_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `video_post`
     WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM video_post
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
}
