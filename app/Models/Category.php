<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class Category extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  public $table = "category";
  protected $fillable = [
    'category_name',
    'status',
    'created_at',
    'updated_at',
  ];
  public static function addEditCategory($request)
  {
    $data['category_name']  = !empty($request['category_name']) ? $request['category_name'] : "";
    $data['status']         = !empty($request['status']) ? (int)$request['status'] : 0;
    $data['type']           = !empty($request['type']) ? (int)$request['type'] : 0;
    $data['slug']           = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['category_name'])));
    if (!empty($request['category_id'])) {
      DB::table('category')->where('category_id', $request['category_id'])->update($data);
    } else {
      DB::table('category')->insert($data);
    }
    return $data;
  }
  public static function addEdithashTag($request)
  {
    $data['has_tag_name']   = !empty($request['has_tag_name']) ? $request['has_tag_name'] : "";
    $data['status']         = !empty($request['status']) ? (int)$request['status'] : 0;
    $data['slug']           = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['has_tag_name'])));
    if (!empty($request['has_tag_id'])) {
      DB::table('has_tag')->where('has_tag_id', $request['has_tag_id'])->update($data);
    } else {
      DB::table('has_tag')->insert($data);
    }
    return $data;
  }
  public static function addEditInSubCategory($request)
  {
    $data['category_id']        = !empty($request['category_id']) ? $request['category_id'] : "";
    $data['sub_cate_id']        = !empty($request['sub_cate_id']) ? $request['sub_cate_id'] : "";
    $data['in_sub_category_name'] = !empty($request['in_sub_category_name']) ? $request['in_sub_category_name'] : "";
    $data['status']             = !empty($request['status']) ? (int)$request['status'] : 0;
    $data['slug']           = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['in_sub_category_name'])));
    $hsdata['has_tag_name']     = $data['in_sub_category_name'];
    $hsdata['status']           = $data['status'];
    if (!empty($request['in_sub_cate_id'])) {
      DB::table('insubcategory')->where('in_sub_cate_id', $request['in_sub_cate_id'])->update($data);
    } else {
      DB::table('insubcategory')->insert($data);
      DB::table('has_tag')->insert($hsdata);
    }
    return $data;
  }
  public static function addEditSubCategory($request)
  {
    $data['category_id']        = !empty($request['category_id']) ? $request['category_id'] : "";
    $data['sub_category_name']  = !empty($request['sub_category_name']) ? $request['sub_category_name'] : "";
    $data['status']             = !empty($request['status']) ? (int)$request['status'] : 0;
    $data['slug']               = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['sub_category_name'])));
    $hsdata['has_tag_name']     = $data['sub_category_name'];
    $hsdata['status']           = $data['status'];
    if (!empty($request['sub_cate_id'])) {
      DB::table('sub_category')->where('sub_cate_id', $request['sub_cate_id'])->update($data);
    } else {
      DB::table('sub_category')->insert($data);
      DB::table('has_tag')->insert($hsdata);
    }
    return $data;
  }
  public static function checkCategoryName($name)
  {
    $row =  DB::table('category')->where('category_name', $name)->first();
    return $row;
  }
  public static function checkHashtagName($name)
  {
    $row =  DB::table('has_tag')->where('has_tag_name', $name)->first();
    return $row;
  }
  public static function chkSubCategory($id)
  {
    $row =  DB::table('sub_category')->where('category_id', $id)->get();
    return $row;
  }
  public static function checkSubCategoryName($name)
  {
    $row =  DB::table('sub_category')->where('sub_category_name', $name)->first();
    return $row;
  }
  public static function checkInSubCategoryName($name)
  {
    $row =  DB::table('insubcategory')->where('in_sub_category_name', $name)->first();
    return $row;
  }
  public static function allCategory()
  {
    $result = DB::table('category')->where('status', 1)->orderBy('category_name', 'asc')->get();
    return $result;
  }
  public static function allCategoryForGames()
  {
    $result = DB::table('category')->where('status', 1)->where('type', 3)->orderBy('category_name', 'asc')->get();
    return $result;
  }
  public static function allsupplider()
  {
    $result = DB::table('supplier')->where('status', 1)->where('service', 1)->orderBy('sulipper_id', 'asc')->get();
    return $result;
  }


public static function moneySuppliders()
  {
    $result = DB::table('supplier')->where('status', 1)->where('service', 2)->orderBy('sulipper_id', 'asc')->get();
    return $result;
  }
  
  public static function checkSubCategoryRow($id)
  {
    $result =  DB::table('sub_category')->where('sub_cate_id', $id)->first();
    return $result;
  }
  public static function sumSuppliderDueAmt($id)
  {
    $result =  DB::table('invoice')->where('sulipper_id', $id)->sum('net_amount');
    return $result;
  }
  public static function sumSuppliderPaidAmt($id)
  {
    $result =  DB::table('supplier_payment')->where('sulipper_id', $id)->sum('amount');
    return $result;
  }
  public static function checkCategoryRow($id)
  {
    $result =  DB::table('category')->where('category_id', $id)->first();
    return $result;
  }
  public static function checkInvoiceMoneyRow($id)
  {
    return DB::table('invoice_money_transfer')
      ->select('invoice_money_transfer.*', 'customer.name as customername', 'customer.addres', 'customer.phone')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice_money_transfer.customer_id')
      ->where('mone_transfer_id', $id)->first();
  }
  public static function checkInvoiceOthersRow($id)
  {
    return DB::table('others_invoice')
      ->select('others_invoice.*', 'customer.name as customername', 'customer.addres', 'customer.phone')
      ->leftJoin('customer', 'customer.customer_id', '=', 'others_invoice.customer_id')
      ->where('others_invoice.others_inv_id', $id)->first();
  }
  public static function checkInvoiceTravelRow($id)
  {
    return DB::table('invoice')
      ->select('invoice.*', 'customer.name as customername', 'customer.addres', 'customer.phone')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice.customer_id')
      ->where('invoice.invoice_id', $id)->first();
  }
  public static function checkCustomerRow($id)
  {
    $result =  DB::table('customer')->where('customer_id', $id)->first();
    return $result;
  }
  public static function checkSupplierRow($id)
  {
    $result =  DB::table('supplier')->where('sulipper_id', $id)->first();
    return $result;
  }
  public static function checkdueAmtRow($id)
  {
    $result =  DB::table('due_amount')->where('due_id', $id)->first();
    return $result;
  }
  public static function checkpaidAmtRow($id)
  {
    return DB::table('supplier_payment')->where('supp_pay_id', $id)->first();
  }
  public static function invoiceData($id)
  {
    $result =  DB::table('invoice')->where('invoice_id', $id)
      ->select('invoice.*', 'customer.type', 'customer.name', 'customer.addres', 'customer.phone')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice.customer_id')
      ->first();
    return $result;
  }
  public static function invoiceForMoneyTData($id)
  {
    $result =  DB::table('invoice_money_transfer')->where('mone_transfer_id', $id)
      ->select('invoice_money_transfer.*', 'customer.type', 'customer.name', 'customer.addres', 'customer.phone')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice_money_transfer.customer_id')
      ->first();
    return $result;
  }

  public static function invoiceForOthersData($id)
  {
    $result =  DB::table('others_invoice')->where('others_inv_id', $id)
      ->select('others_invoice.*', 'customer.type', 'customer.name', 'customer.addres', 'customer.phone')
      ->leftJoin('customer', 'customer.customer_id', '=', 'others_invoice.customer_id')
      ->first();
    return $result;
  }


  public static function invoiceDataAll($id)
  {
    $result =  DB::table('invoice')->where('inv_id', $id)
      ->select('invoice.*', 'customer.type', 'customer.name as customername', 'customer.addres', 'customer.phone', 'supplier.name as suppliername')
      ->leftJoin('customer', 'customer.customer_id', '=', 'invoice.customer_id')
      ->leftJoin('supplier', 'supplier.sulipper_id', '=', 'invoice.sulipper_id')
      ->first();
    return $result;
  }
  public static function allCustomers()
  {
    $result =  DB::table('customer')->where('status', 1)->get();
    return $result;
  }
  public static function getCustomerlist()
  {
    $result =  DB::table('customer')->where('type', 1)->where('status', 1)->get();
    return $result;
  }
  public static function AllCustomersMoney()
  {
    $result =  DB::table('customer')->where('type', 2)->where('status', 1)->get();
    return $result;
  }
  public static function AllCustomersOthers()
  {
    $result =  DB::table('customer')->where('type', 3)->where('status', 1)->get();
    return $result;
  }
  public static function checkHashTagRow($id)
  {
    $result =  DB::table('has_tag')->where('has_tag_id', $id)->first();
    return $result;
  }
  public static function checkInSubCategoryRow($id)
  {
    $result =  DB::table('insubcategory')->where('in_sub_cate_id', $id)->first();
    return $result;
  }
  public static function filterInSubCategoryList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['category'])) {
      $cond .= " AND insubcategory.in_sub_category_name LIKE '%" . $data['category'] . "%'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND insubcategory.status IN({$st})";
    $cond .= " ORDER BY insubcategory.in_sub_cate_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT insubcategory.*,category.category_name,sub_category.sub_category_name
              FROM `insubcategory` 
              LEFT JOIN category ON (category.category_id=insubcategory.category_id) 
              LEFT JOIN sub_category ON (sub_category.sub_cate_id=insubcategory.sub_cate_id) 
              WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `insubcategory` WHERE 1 {$cond}";
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
  public static function filterSubCategoryList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['category'])) {
      $cond .= " AND sub_category.sub_category_name LIKE '%" . $data['category'] . "%'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND sub_category.status IN({$st})";
    $cond .= " ORDER BY sub_category.sub_cate_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT sub_category.*,category.category_name 
              FROM `sub_category` 
              LEFT JOIN category ON (category.category_id=sub_category.category_id) WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM `sub_category` WHERE 1 {$cond}";
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
  public static function filterAdsList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['name'])) {
      $cond .= " AND ads.name LIKE '%" . $data['name'] . "%'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND ads.status IN({$st})";
    $cond .= " ORDER BY ads.id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `ads` WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM ads WHERE 1 {$cond}";
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
  public static function filterCustomerList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['name'])) {
      $cond .= " AND customer.name LIKE '%" . $data['name'] . "%'";
    }
    if (!empty($data['type'])) {
      $cond .= " AND customer.type='" . $data['type'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND customer.status IN({$st})";
    $cond .= " ORDER BY customer.customer_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `customer` WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM customer WHERE 1 {$cond}";
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
  public static function filterDueAmountList($data = array())
  {
    //dd($data);
    $cond = '';
    // if (!empty($data['name'])) {
    //   $cond .= " AND supplier.name LIKE '%" . $data['name'] . "%'";
    // }
    if (!empty($data['sulipper_id'])) {
      $cond .= " AND due_amount.sulipper_id='" . $data['sulipper_id'] . "'";
    }
    // if (!empty($data['service'])) {
    //   $cond .= " AND supplier.service='" . $data['service'] . "'";
    // }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    //$cond .= " AND supplier.status IN({$st})";
    $cond .= " ORDER BY due_amount.due_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT users.name as entryby,due_amount.due_id,due_amount.dueamt,supplier.name as suppliername FROM `due_amount` 
    LEFT JOIN supplier ON (supplier.sulipper_id=due_amount.sulipper_id)
    LEFT JOIN users ON (users.id=due_amount.entry_by) 
    WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM due_amount 
                          LEFT JOIN supplier ON (supplier.sulipper_id=due_amount.sulipper_id)
                          LEFT JOIN users ON (users.id=due_amount.entry_by) 
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
  public static function filterPayment($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['sulipper_id'])) {
      $cond .= " AND supplier_payment.sulipper_id='" . $data['sulipper_id'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    //$cond .= " AND supplier.status IN({$st})";
    $cond .= " ORDER BY supplier_payment.supp_pay_id ASC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT users.name as entryby,supplier_payment.supp_pay_id,supplier_payment.sulipper_id,supplier_payment.previous_due,supplier_payment.amount,supplier_payment.due,supplier.name as suppliername FROM `supplier_payment` 
    LEFT JOIN supplier ON (supplier.sulipper_id=supplier_payment.sulipper_id)
    LEFT JOIN users ON (users.id=supplier_payment.entry_by) 
    WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM supplier_payment 
                          LEFT JOIN supplier ON (supplier.sulipper_id=supplier_payment.sulipper_id)
                          LEFT JOIN users ON (users.id=supplier_payment.entry_by) 
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
  public static function filterSupplierList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['name'])) {
      $cond .= " AND supplier.name LIKE '%" . $data['name'] . "%'";
    }
    if (!empty($data['type'])) {
      $cond .= " AND supplier.type='" . $data['type'] . "'";
    }
    if (!empty($data['service'])) {
      $cond .= " AND supplier.service='" . $data['service'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND supplier.status IN({$st})";
    $cond .= " ORDER BY supplier.sulipper_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `supplier` WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM supplier WHERE 1 {$cond}";
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
  public static function filterInvoiceListMoney($data = array())
  {
    //dd($data);
    $table = 'invoice_money_transfer';
    $cond = '';
    if (!empty($data['beneficiary_name'])) {
      $cond .= " AND $table.beneficiary_name LIKE '%" . $data['beneficiary_name'] . "%'";
    }
    if (!empty($data['payment_type'])) {
      $cond .= " AND $table.payment_type='" . $data['payment_type'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND $table.status IN({$st})";
    $cond .= " ORDER BY {$table}.mone_transfer_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `{$table}` LEFT JOIN customer ON (customer.customer_id=invoice_money_transfer.customer_id) WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM $table  WHERE 1 {$cond}";
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
  public static function filterInvoiceListOthers($data = array())
  {
    //dd($data);
    $table = 'others_invoice';
    $cond = '';
    if (!empty($data['purpose'])) {
      $cond .= " AND $table.purpose='" . $data['purpose'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND $table.status IN({$st})";
    $cond .= " ORDER BY {$table}.others_inv_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `{$table}` LEFT JOIN customer ON (customer.customer_id=others_invoice.customer_id) WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM $table  WHERE 1 {$cond}";
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
  public static function filterInvoiceReturnList($data = array())
  {
    //dd($data);
    $tbl = 'invoice_return_travel';
    $cond = '';
    if (!empty($data['customer_id'])) {
      $cond .= " AND {$tbl}.customer_id='" . $data['customer_id'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND {$tbl}.status IN({$st})";
    $cond .= " ORDER BY {$tbl}.inv_ret_travel_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT {$tbl}.*,customer.name as customername,customer.addres,customer.phone,invoice.inv_id FROM `{$tbl}` 
              LEFT JOIN customer ON (customer.customer_id={$tbl}.customer_id) 
              LEFT JOIN invoice ON (invoice.invoice_id={$tbl}.invoice_id)
              WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM {$tbl} 
    LEFT JOIN customer ON (customer.customer_id={$tbl}.customer_id)
    LEFT JOIN invoice ON (invoice.invoice_id={$tbl}.invoice_id)
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
  public static function filterInvoiceList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['inv_id'])) {
      $cond .= " AND invoice.inv_id LIKE '%" . $data['inv_id'] . "%'";
    }
    if (!empty($data['customer_id'])) {
      $cond .= " AND invoice.customer_id='" . $data['customer_id'] . "'";
    }
    if (!empty($data['payment_type'])) {
      $cond .= " AND invoice.payment_type='" . $data['payment_type'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND invoice.status IN({$st})";
    $cond .= " ORDER BY invoice.invoice_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT invoice.*,customer.name,customer.addres,customer.phone FROM `invoice` LEFT JOIN customer ON (customer.customer_id=invoice.customer_id) WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM invoice LEFT JOIN customer ON (customer.customer_id=invoice.customer_id) WHERE 1 {$cond}";
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
  public static function filterCategoryList($data = array())
  {
    //dd($data);
    $cond = '';
    if (!empty($data['category'])) {
      $cond .= " AND category.category_name LIKE '%" . $data['category'] . "%'";
    }
    if (!empty($data['type'])) {
      $cond .= " AND category.type='" . $data['type'] . "'";
    }
    $st = '0,1';
    if (isset($data['status'])) {
      $st = $data['status'];
    }
    $cond .= " AND category.status IN({$st})";
    $cond .= " ORDER BY category.category_id DESC";
    $limit = $data['length']; //10
    if (!empty($data['page'])) {
      $start = $limit * ($data['page'] - 1);
    }
    $sqld = "SELECT * FROM `category` WHERE 1 " . $cond;
    $sqld .= " LIMIT $start,$limit";
    //echo $sqld;exit; 
    $results = DB::select($sqld);
    $sqlt = "SELECT count(*)total FROM category WHERE 1 {$cond}";
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
