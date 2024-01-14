<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Category;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
class CategoryController extends Controller
{
    public function inSaveSubCategory(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'sub_cate_id' => 'required',
            'in_sub_category_name' => 'required',
            'status' => 'required',
        ]);
        $data = Category::addEditInSubCategory($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function saveSubCategory(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'sub_category_name' => 'required',
            'status' => 'required',
        ]);
        $data = Category::addEditSubCategory($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function saveCategory(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required',
            'status' => 'required',
        ]);
        $data = Category::addEditCategory($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function saveHashTag(Request $request)
    {
        $this->validate($request, [
            'has_tag_name' => 'required',
            'status' => 'required',
        ]);
        $data = Category::addEdithashTag($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editInSubCategoryId($id)
    {
        $data = Category::checkInSubCategoryRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editSubCategoryId($id)
    {
        $data = Category::checkSubCategoryRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editCategoryId($id)
    {
        $data = Category::checkCategoryRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editInvoiceMoneyId($id)
    {
        $data = Category::checkInvoiceMoneyRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editInvoiceOthresId($id)
    {
        $data = Category::checkInvoiceOthersRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editInvoiceTravelId($id)
    {
        $data = Category::checkInvoiceTravelRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function allCustomers()
    {
        $data = Category::AllCustomers();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function allCustomerslist()
    {
        $data = Category::getCustomerlist();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function allCustomerMoney()
    {
        $data = Category::AllCustomersMoney();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function allCustomerOthers()
    {
        $data = Category::AllCustomersOthers();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editSupplierId($id)
    {
        $data = Category::checkSupplierRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editDueAmtId($id)
    {
        $data = Category::checkdueAmtRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editPaidAmtId($id)
    {
        $data = Category::checkpaidAmtRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editCustomerId($id)
    {
        $data = Category::checkCustomerRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getInvoiceData($id)
    {
        $data           = Category::invoiceData($id);
        //dd($data);
        $crdate         =  $data->created_at;
        $create_date    = date('d-m-Y', strtotime($crdate));
        $entryBy        = user::checkUserRow($data->entry_by);
        $response = [
            'data'          => $data,
            'create_date'   => $create_date,
            'entry_by'      => !empty($entryBy->name) ? $entryBy->name : "",
            'message'       => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getInvoiceMoneyData($id)
    {
        $data           = Category::invoiceForMoneyTData($id);
        // dd($data);
        $crdate         =  $data->create_date;
        $create_date    = date('d-m-Y', strtotime($crdate));
        $ref            =  $data->transaction_ref;
        $invoice_date   =  $data->invoice_date;
        $invoice_date   = date('d-m-Y', strtotime($invoice_date));

        $entryBy        = user::checkUserRow($data->entry_by);
        $response = [
            'data'            => $data,
            'create_date'     => $create_date,
            'invoice_date'    => $invoice_date,
            'transaction_ref' => $ref,
            'entry_by'      => !empty($entryBy->name) ? $entryBy->name : "",
            'message'       => 'success'
        ];
        return response()->json($response, 200);
    }



 public function getInvoiceOthersData($id)
    {
        $data           = Category::invoiceForOthersData($id);
        //dd($data);
        $crdate         =  $data->create_date;
        $create_date    = date('d-m-Y', strtotime($crdate));
        $entryBy        = user::checkUserRow($data->entry_by);
        $response = [
            'data'          => $data,
            'create_date'   => $create_date,
            'entry_by'      => !empty($entryBy->name) ? $entryBy->name : "",
            'message'       => 'success'
        ];
        return response()->json($response, 200);
    }




    
    public function getInvoiceDataChk($id)
    {
        $data = Category::invoiceDataAll($id);
        if (!empty($data)) {
            $response = [
                'data' => $data,
                'message' => 'success'
            ];
        } else {
            $response = [
                'data' => 'Data not found',
                'message' => 'error'
            ];
        }
        return response()->json($response, 200);
    }
    public function editHashTagId($id)
    {
        $data = Category::checkHashTagRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getCategoryList()
    {
        $data = Category::allCategory();
        // dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function gamesCategory()
    {
        $data = Category::allCategoryForGames();
        // dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function allsuppliders()
    {
        $data = Category::allsupplider();
        // dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }

public function moneySuppliders()
    {
        $data = Category::moneySuppliders();
        // dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }


    
    public function chkCategoryId(Request $request)
    {
        $data = Category::chkSubCategory($request->categoryid);
        // dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function chkSupplierAmt(Request $request)
    {
        $data = Category::sumSuppliderDueAmt($request->sulipper_id);
        //dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function chkSupplierWiseDueAmt(Request $request)
    {
        $due_amount = Category::sumSuppliderDueAmt($request->sulipper_id);
        $check_amount = Category::sumSuppliderPaidAmt($request->sulipper_id);
        $first = !empty($due_amount) ? $due_amount : 0;
        $second = !empty($check_amount) ? $check_amount : 0;
        $result = $first - $second;
        $response = [
            'due_amount' => $due_amount,
            'data' => $result,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function checkSubCateName(Request $request)
    {
        $row = Category::checkSubCategoryName($request->sub_category_name);
        //dd($data);
        if (empty($row)) {
            $data['status'] = 0; //no category; 
        } else {
            $data['status'] = 1; //avialable category; 
        }
        return response()->json($data);
    }
    public function checkInSubCateName(Request $request)
    {
        $row = Category::checkInSubCategoryName($request->in_sub_category_name);
        //dd($data);
        if (empty($row)) {
            $data['status'] = 0; //no category; 
        } else {
            $data['status'] = 1; //avialable category; 
        }
        return response()->json($data);
    }
    public function checkhastagName(Request $request)
    {
        $row = Category::checkHashtagName($request->has_tag_name);
        //dd($data);
        if (empty($row)) {
            $data['status'] = 0; //no category; 
        } else {
            $data['status'] = 1; //avialable category; 
        }
        return response()->json($data);
    }
    public function checkCateName(Request $request)
    {
        $row = Category::checkCategoryName($request->category_name);
        //dd($data);
        if (empty($row)) {
            $data['status'] = 0; //no category; 
        } else {
            $data['status'] = 1; //avialable category; 
        }
        return response()->json($data);
    }
    public function getCustomerData(Request $request)
    {
        $users = Category::filterCustomerList($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->type == 1) {
                $sdata['type'] = '<span class="badge bg-primary">Travel</span></span>';
            } elseif ($v->type == 2) {
                $sdata['type'] = '<span class="badge bg-success">Money Transfer</span></span>';
            } elseif ($v->type == 3) {
                $sdata['type'] = '<span class="badge bg-success">Others</span></span>';
            }
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['name'] = !empty($v->name) ? $v->name : '-';
            $sdata['addres'] = !empty($v->addres) ? $v->addres : '-';
            $sdata['phone'] = !empty($v->phone) ? $v->phone : '-';
            //$sdata['actions'] = Helper::sprint('<button class="edit" data-id="{customer_id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{customer_id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{customer_id}"><i class="fas fa-edit"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getDueAmountlist(Request $request)
    {
        $users = Category::filterDueAmountList($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            $sdata['suppliername'] = !empty($v->suppliername) ? $v->suppliername : '-';
            $sdata['dueamt'] = !empty($v->dueamt) ? $v->dueamt : '-';
            $sdata['entryby'] = !empty($v->entryby) ? $v->entryby : '-';
            $sdata['due_id'] = !empty($v->due_id) ? $v->due_id : '-';
            //$sdata['actions'] = Helper::sprint('<button class="edit" data-id="{customer_id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{customer_id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{due_id}"><i class="fas fa-edit"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getPaymentAmountlist(Request $request)
    {
        $users = Category::filterPayment($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            $sdata['suppliername'] = !empty($v->suppliername) ? $v->suppliername : '-';
            // $sdata['previous_due']      = !empty($v->previous_due) ? $v->previous_due : 0;  
            $sdata['due'] = !empty($v->due) ? $v->due : 0;
            $sdata['amount'] = !empty($v->amount) ? $v->amount : 0;
            $sdata['entryby'] = !empty($v->entryby) ? $v->entryby : '-';
            $sdata['supp_pay_id'] = $v->supp_pay_id;
            //$sdata['actions'] = Helper::sprint('<button class="edit" data-id="{customer_id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{customer_id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{supp_pay_id}"><i class="fas fa-edit"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getSupplierData(Request $request)
    {
        $users = Category::filterSupplierList($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->service == 1) {
                $sdata['service'] = '<span class="badge bg-primary">Travel</span></span>';
            } 
            
            if($v->service == 2) {
                $sdata['service'] = '<span class="badge bg-success">Money Transfer</span></span>';
            }
            
            if($v->service == 3) {
            $sdata['service'] = '<span class="badge bg-success">Others</span></span>';
            }
        
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['name'] = !empty($v->name) ? $v->name : '-';
            $sdata['type'] = !empty($v->type) ? $v->type : '-';
            //$sdata['actions'] = Helper::sprint('<button class="edit" data-id="{customer_id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{customer_id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{sulipper_id}"><i class="fas fa-edit"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getAdsData(Request $request)
    {
        $users = Category::filterAdsList($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            if (!empty($v->image)) {
                $sdata['image'] = Helper::sprint('<img src="' . $v->image . '" class="rounded mx-auto d-block"">');
            } else {
                $sdata['image'] = Helper::sprint('<img src="/public/backend/blank_profile.png">', $v);
            }
            $sdata['name'] = !empty($v->name) ? $v->name : '-';
            $sdata['id'] = !empty($v->id) ? $v->id : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function saveInvoiceMoney(Request $request)
    {
        $authId = (int) Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'invoice_date'      => 'required',
            'beneficiary_name'      => 'required',
            'beneficiary_city'      => 'required',
            'beneficiary_country'   => 'required',
            // 'beneficary_contact_num' => 'required',
            'rate'                  => 'required',
            'fees'                  => 'required',
            'customer_id'           => 'required',
            'receiving_amount'      => 'required',
            'payment_type'          => 'required',
            'others_fees'          => 'required',
            'net_amount'            => 'required',
            'profit'                => 'required',
            'customer_deposit'      => 'required',
            'due_amount'            => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        if ($request->payment_type == 1) {
            $bkash_number = $request->bkash_number;
        }
        if ($request->payment_type == 2) {
            $bank_name = $request->bank_name;
            $branch_name = $request->branch_name;
            $acc_no = $request->acc_no;
        }
        if ($request->payment_type == 3) {
            $bank_name = $request->bank_name;
            $branch_name = $request->branch_name;
        }
        //dd($request->invoice_date);
        $data = array(
            'invoice_date'              => !empty($request->invoice_date) ? date("Y-m-d",strtotime($request->invoice_date)) : "",
            'beneficiary_name'          => !empty($request->beneficiary_name) ? $request->beneficiary_name : "",
            'beneficiary_city'          => !empty($request->beneficiary_city) ? $request->beneficiary_city : "",
            'beneficiary_country'       => !empty($request->beneficiary_country) ? $request->beneficiary_country : "",
            'beneficary_contact_num'    => !empty($request->beneficary_contact_num) ? $request->beneficary_contact_num : "",
            'transaction_ref'           => !empty($request->transaction_ref) ? $request->transaction_ref : "",
            'rate'                      => !empty($request->rate) ? $request->rate : "",
            'fees'                      => !empty($request->fees) ? $request->fees : "",
            'payment_receive'           => !empty($request->payment_receive) ? $request->payment_receive : "",
            'customer_id'               => !empty($request->customer_id) ? $request->customer_id : "",
            'sulipper_id'               => !empty($request->sulipper_id) ? $request->sulipper_id : "",
            'receiving_amount'          => !empty($request->receiving_amount) ? $request->receiving_amount : "",
            'total_amount'              => !empty($request->total_amount) ? $request->total_amount : "",
            'payment_type'              => !empty($request->payment_type) ? $request->payment_type : "",
            'others_fees'               => !empty($request->others_fees) ? $request->others_fees : "",
            'net_amount'                => !empty($request->net_amount) ? $request->net_amount : "",
            'profit'                    => !empty($request->profit) ? $request->profit : "",
            'customer_deposit'          => !empty($request->customer_deposit) ? $request->customer_deposit : "",
            'due_amount'                => !empty($request->due_amount) ? $request->due_amount : "",
            'bkash_number'              => !empty($bkash_number) ? $bkash_number : "",
            'acc_no'                    =>  !empty($acc_no) ? $acc_no : "",
            'bank_name'                 => !empty($bank_name) ? $bank_name : "",
            'branch_name'               => !empty($branch_name) ? $branch_name : "",
            'status'                    => 1,
            'entry_by'                  => $authId,
        );
       // dd($data);
        if (empty($request->mone_transfer_id)) {
            DB::table('invoice_money_transfer')->insertGetId($data);
        } else {
            DB::table('invoice_money_transfer')->where('mone_transfer_id', $request->mone_transfer_id)->update($data);
        }
        $response = [
            'message' => 'Successfully Working',
        ];
        return response()->json($response);
    }
    public function saveInvoiceOthers(Request $request)
    {
        //dd($request->all());
        $authId = (int) Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'invoice_date'          => 'required',
            'customer_id'           => 'required',
            'purpose'               => 'required',
            'net_amount'            => 'required',
            'customer_amount'       => 'required',
            'amount_paid'           => 'required',
            'profit'                => 'required',
            'due_amount'            => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $data = array(
            'invoice_date'              => !empty($request->invoice_date) ? date("d-m-Y", strtotime($request->invoice_date)) : "",
            'customer_id'               => !empty($request->customer_id) ? $request->customer_id : "",
            'purpose'                   => !empty($request->purpose) ? $request->purpose : "",
            'net_amount'                => !empty($request->net_amount) ? $request->net_amount : "",
            'customer_amount'           => !empty($request->customer_amount) ? $request->customer_amount : "",
            'amount_paid'               => !empty($request->amount_paid) ? $request->amount_paid : "",
            'profit'                    => !empty($request->profit) ? $request->profit : "",
            'due_amount'                => !empty($request->due_amount) ? $request->due_amount : "",
            'status'                    => 1,
            'entry_by'                  => $authId,
        );
        if (empty($request->others_inv_id)) {
            DB::table('others_invoice')->insertGetId($data);
        } else {
            DB::table('others_invoice')->where('others_inv_id', (int)$request->others_inv_id)->update($data);
        }
        $response = [
            'message' => 'Successfully Working',
        ];
        return response()->json($response);
    }
    public function saveInvoiceReturn(Request $request)
    {
        // dd($request->all());
        $authId = (int) Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'invoice_id' => 'required',
            'return_amount' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $profit_result = $request->net_amount - $request->return_amount;
        if (!empty($request->invoice_id)) {
            $return_inv_id = DB::table('invoice')->where('invoice_id', $request->invoice_id)->first();
            $data['profit'] = $profit_result;
            //$data['status'] = 2;//return
            DB::table('invoice')->where('invoice_id', $request->invoice_id)->update($data);
        }
        $data = array(
            'customer_id'    => !empty($request->customer_id) ? (int) $request->customer_id : "",
            'invoice_id'     => !empty($request->invoice_id) ? (int) $request->invoice_id : "",
            'return_amount'  => !empty($request->return_amount) ? $request->return_amount : 0,
            'net_amount'     => !empty($request->net_amount) ? $request->net_amount : 0,
            'profit'         => $profit_result,
            'status'         => 1,
            'entry_by' => $authId, //!empty($request->due_amount) ? $request->due_amount : "",
        );
        //dd($data);
        if (empty($request->inv_ret_travel_id)) {
            $return_inv_id = DB::table('invoice_return_travel')->insertGetId($data);
        } else {
            DB::table('invoice_return_travel')->where('inv_ret_travel_id', $request->inv_ret_travel_id)->update($data);
        }
        $response = [
            'return_inv_id' => $return_inv_id,
            'message' => 'Successfully Working',
        ];
        return response()->json($response);
    }
    public function saveInvoice(Request $request)
    {
        $authId = (int) Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'invoice_date' => 'required',
            'customer_id' => 'required',
            'sulipper_id' => 'required',
            'customer_amount' => 'required',
            'profit' => 'required',
            'customer_deposit' => 'required',
            'due_amount' => 'required',
            'payment_type' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $data = array(
            'invoice_date'              => !empty($request->invoice_date) ? date("d-m-Y", strtotime($request->invoice_date)) : "",
            'customer_id'               => !empty($request->customer_id) ? (int) $request->customer_id : "",
            'sulipper_id'               => !empty($request->sulipper_id) ? (int) $request->sulipper_id : "",
            'net_amount'                => !empty($request->net_amount) ? $request->net_amount : "",
            'add_pesenger'              => !empty($request->add_pesenger) ? $request->add_pesenger : "",
            'customer_amount'           => !empty($request->customer_amount) ? $request->customer_amount : "",
            'profit'                    => !empty($request->profit) ? $request->profit : "",
            'customer_deposit'          => !empty($request->customer_deposit) ? $request->customer_deposit : "",
            'due_amount'                => !empty($request->due_amount) ? $request->due_amount : "",
            'payment_type'              => !empty($request->payment_type) ? $request->payment_type : "",
            'depart_from'               => !empty($request->depart_from) ? $request->depart_from : "",
            'depart_to'                 => !empty($request->depart_to) ? $request->depart_to : "",
            'airline'                   => !empty($request->airline) ? $request->airline : "",
            'flight_no'                 => !empty($request->flight_no) ? $request->flight_no : "",
            'class'                     => !empty($request->class) ? $request->class : "",
            'departure_time'            => !empty($request->departure_time) ? $request->departure_time : "",
            'departure_date'            => !empty($request->departure_date) ? date("Y-m-d", strtotime($request->departure_date)) : "",
            'arrival_date'              => !empty($request->arrival_date) ? date("Y-m-d", strtotime($request->arrival_date)) : "",
            'arrival_time'              => !empty($request->arrival_time) ? $request->arrival_time : "",
            'duration'                  => !empty($request->duration) ? $request->duration : "",
            'baggage'                   => !empty($request->baggage) ? $request->baggage : "",
            'ticketno'                  => !empty($request->ticketno) ? $request->ticketno : "",
            'vendorpnr'                 => !empty($request->vendorpnr) ? $request->vendorpnr : "",
            'status'                    => 1,
            'entry_by' => $authId, //!empty($request->due_amount) ? $request->due_amount : "",
        );
        if (empty($request->invoice_id)) {
            $inv_count = DB::table('invoice')->count();
            if ($inv_count > 0) {
                $count = $inv_count + 1;
                $data['inv_id'] = "HMN" . sprintf('%06d', $count);
            } else {
                $count = '0000001';
                $data['inv_id'] = "HMN" . sprintf('%06d', $count);
            }
            $invoice_id = DB::table('invoice')->insertGetId($data);
        } else {
            DB::table('invoice')->where('invoice_id', $request->invoice_id)->update($data);
            $invoice_id = $request->invoice_id;
        }
        $response = [
            'customer_id' => $invoice_id,
            'message' => 'Successfully Working',
        ];
        return response()->json($response);
    }
    public function saveCustomer(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $data = array(
            'name' => !empty($request->name) ? $request->name : "",
            'phone' => !empty($request->phone) ? $request->phone : "",
            'addres' => !empty($request->addres) ? $request->addres : "",
            'type' => !empty($request->type) ? $request->type : "",
            'destination' => !empty($request->destination) ? $request->destination : "",
            'status' => $request->status,
        );
        //dd($data);
        if (empty($request->customer_id)) {
            DB::table('customer')->insertGetId($data);
        } else {
            DB::table('customer')->where('customer_id', $request->customer_id)->update($data);
        }
        $response = [
            'message' => 'Successfully Working',
        ];
        return response()->json($response);
    }
    public function saveDueAmt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sulipper_id' => 'required',
            'dueamt' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $authId = (int) Auth::user()->id;
        $data = array(
            'sulipper_id' => !empty($request->sulipper_id) ? $request->sulipper_id : "",
            'dueamt' => !empty($request->dueamt) ? $request->dueamt : "",
            'entry_by' => $authId,
        );
        // DB::table('posts')->where('id', 1)->delete();
        if (empty($request->due_id)) {
            DB::table('due_amount')->insertGetId($data);
            // $chkDueAmt =  DB::table('due_amount')->where('sulipper_id', $request->sulipper_id)->where('dueamt', $request->dueamt)->first();
            // if(empty($chkDueAmt)){
            // }
        } else {
            DB::table('due_amount')->where('due_id', $request->due_id)->update($data);
        }
        $response = [
            'message' => 'Successfully Working',
        ];
        return response()->json($response);
    }
    public function savePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sulipper_id' => 'required',
            'dueamt' => 'required',
            'amount' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $authId = (int) Auth::user()->id;
        $data = array(
            'sulipper_id' => !empty($request->sulipper_id) ? $request->sulipper_id : "",
            'previous_due' => !empty($request->dueamt) ? $request->dueamt : "",
            'due' => $request->dueamt - $request->amount,
            'amount' => !empty($request->amount) ? $request->amount : "",
            'entry_by' => $authId,
        );
        // DB::table('posts')->where('id', 1)->delete();
        if (empty($request->supp_pay_id)) {
            if ($request->dueamt > 0) {
                DB::table('supplier_payment')->insertGetId($data);
            }
        } else {
            DB::table('supplier_payment')->where('supp_pay_id', $request->supp_pay_id)->update($data);
        }
        $response = [
            'message' => 'Successfully Working',
        ];
        return response()->json($response);
    }
    public function saveSupplier(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'service' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $data = array(
            'name' => !empty($request->name) ? $request->name : "",
            'type' => !empty($request->type) ? $request->type : "",
            'service' => !empty($request->service) ? $request->service : "",
            'status' => $request->status,
        );
        if (empty($request->sulipper_id)) {
            DB::table('supplier')->insertGetId($data);
        } else {
            DB::table('supplier')->where('sulipper_id', $request->sulipper_id)->update($data);
        }
        $response = [
            'message' => 'Successfully Working',
        ];
        return response()->json($response);
    }
    public function addAds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
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
            if (!empty($request->id)) {
                if (!empty($request->file('file'))) {
                    //For Live Start
                    $files = $request->file('file');
                    $fileName = Str::random(20);
                    $ext = strtolower($files->getClientOriginalExtension());
                    $path = $fileName . '.' . $ext;
                    $uploadPath = '';
                    $upload_url = $uploadPath . $path;
                    $files->move(public_path('/backend/files/'), $upload_url);
                    //END 
                } else {
                    $row = DB::table('ads')->where('id', $request->id)->first();
                    $file_url = !empty($row->image) ? $row->image : "";
                }
            } else {
                $file_url = "";
            }
        }
        $data = array(
            'name' => !empty($request->name) ? $request->name : "",
            'href_link' => !empty($request->href_link) ? $request->href_link : "",
            'image' => $file_url,
            'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name))),
            'status' => $request->status,
        );
        if (empty($request->id)) {
            $userId = DB::table('ads')->insertGetId($data);
        } else {
            $userId = $request->id;
            DB::table('ads')->where('id', $request->id)->update($data);
        }
        $response = [
            'imagelink' => !empty($file_url) ? $file_url : $file_url,
            'message' => 'User register successfully update'
        ];
        return response()->json($response);
    }
    public function getCategoryData(Request $request)
    {
        $users = Category::filterCategoryList($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['category_name'] = !empty($v->category_name) ? $v->category_name : '-';
            $sdata['order_id'] = !empty($v->order_id) ? $v->order_id : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{category_id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{category_id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getInvoicesmoneylist(Request $request)
    {
        $users = Category::filterInvoiceListMoney($request->all());
        // dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->payment_type == 1) {
                $sdata['payment_type'] = '<span class="badge bg-success">Bkash</span></span>';
            } elseif ($v->payment_type == 2) {
                $sdata['payment_type'] = '<span class="badge bg-success">Bank Transfer</span></span>';
            } elseif ($v->payment_type == 3) {
                $sdata['payment_type'] = '<span class="badge bg-success">Cash</span></span>';
            }
            $sdata['mone_transfer_id'] = $v->mone_transfer_id;
            $sdata['transaction_ref'] = $v->transaction_ref;
            $sdata['customer_name']    = $v->name;
            $bn_name    = !empty($v->beneficiary_name) ? $v->beneficiary_name : '-';
            $bn_city    = !empty($v->beneficiary_city) ? $v->beneficiary_city : '-';
            $bn_country = !empty($v->beneficiary_country) ? $v->beneficiary_country : '-';
            $bn_num     = !empty($v->beneficary_contact_num) ? $v->beneficary_contact_num : '-';
            $sdata['beneficiary_name']       = "Name: $bn_name<br> City:$bn_city<br>Country:$bn_country<br>Phone:$bn_num";
            $sdata['rate'] = !empty($v->rate) ? number_format($v->rate, 2) : '-';
            $sdata['fees'] = !empty($v->fees) ? number_format($v->fees, 2) : '-';
            $sdata['receiving_amount'] = !empty($v->receiving_amount) ? number_format($v->receiving_amount, 2) : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{mone_transfer_id}"><i class="fas fa-edit"></i></button> <button class="print" data-id="{mone_transfer_id}"><i class="fas fa-print"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getInvoicesOtherslist(Request $request)
    {
        $inv = Category::filterInvoiceListOthers($request->all());
        // dd($users);
        $data = array();
        foreach ($inv['data'] as $key => $v) {
            $sdata['others_inv_id']     = $v->others_inv_id;
            $sdata['customer_name']     = $v->name;
            $sdata['purpose']           = $v->purpose;
            $sdata['customer_amount']   = !empty($v->customer_amount) ? number_format($v->customer_amount, 2) : '0.00';
            $sdata['net_amount']        = !empty($v->net_amount) ? number_format($v->net_amount, 2) : '0.00';
            $sdata['amount_paid']       = !empty($v->amount_paid) ? number_format($v->amount_paid, 2) : '0.00';
            $sdata['profit']            = !empty($v->profit) ? number_format($v->profit, 2) : '0.00';
            $sdata['due_amount']        = !empty($v->due_amount) ? number_format($v->due_amount, 2) : '0.00';
           $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{others_inv_id}"><i class="fas fa-edit"></i></button> <button class="print" data-id="{others_inv_id}"><i class="fas fa-print"></i></button>', $v);
            //$sdata['actions'] = Helper::sprint('<button class="edit" data-id="{others_inv_id}"><i class="fas fa-edit"></i></button>', $v);
            $data[] = $sdata;
        }
        $inv['data'] = $data;
        return response()->json($inv, 200);
    }
    public function invoicesReturnForTravellist(Request $request)
    {
        $users = Category::filterInvoiceReturnList($request->all());
        // dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            $entryBy = user::checkUserRow($v->entry_by);
            $sdata['inv_id'] = $v->inv_id;
            $sdata['inv_ret_travel_id'] = $v->inv_ret_travel_id;
            $sdata['profit'] = $v->profit;
            $sdata['customername'] = !empty($v->customername) ? $v->customername : '-';
            $sdata['return_amount'] = !empty($v->return_amount) ? $v->return_amount : '-';
            $sdata['entry_by'] = !empty($entryBy) ? $entryBy->name : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{inv_ret_travel_id}"><i class="fas fa-print"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
    }
    public function getInvoiceslist(Request $request)
    {
        $users = Category::filterInvoiceList($request->all());
        // dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->payment_type == 1) {
                $sdata['payment_type'] = '<span class="badge bg-success">Bank Transfer</span></span>';
            } elseif ($v->payment_type == 2) {
                $sdata['payment_type'] = '<span class="badge bg-success">Card Payment</span></span>';
            } elseif ($v->payment_type == 3) {
                $sdata['payment_type'] = '<span class="badge bg-success">Cash</span></span>';
            }
            $sdata['invoice_id'] = $v->invoice_id;
            $sdata['inv_id']     = $v->inv_id;
            $sdata['name'] = !empty($v->name) ? $v->name : '-';
            $sdata['profit'] = !empty($v->profit) ? $v->profit : '-';
            $sdata['net_amount'] = !empty($v->net_amount) ? $v->net_amount : '-';
            // $sdata['payment_type']   = !empty($v->order_id) ? $v->order_id : '-';
            $sdata['actions'] = Helper::sprint('<button class="print" data-id="{invoice_id}"><i class="fas fa-print"></i></button> <button class="edit" data-id="{invoice_id}"><i class="fas fa-pencil"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getInSubCategoryData(Request $request)
    {
        $rows = Category::filterInSubCategoryList($request->all());
        $data = array();
        foreach ($rows['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['category_name'] = !empty($v->category_name) ? $v->category_name : '-';
            $sdata['sub_category_name'] = !empty($v->sub_category_name) ? $v->sub_category_name : '-';
            $sdata['in_sub_category_name'] = !empty($v->in_sub_category_name) ? $v->in_sub_category_name : '-';
            $sdata['account_number'] = !empty($v->account_number) ? $v->account_number : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{sub_cate_id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{sub_cate_id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $rows['data'] = $data;
        return response()->json($rows, 200);
        //  dd($data);
    }
    public function getSubCategoryData(Request $request)
    {
        $rows = Category::filterSubCategoryList($request->all());
        $data = array();
        foreach ($rows['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['category_name'] = !empty($v->category_name) ? $v->category_name : '-';
            $sdata['sub_category_name'] = !empty($v->sub_category_name) ? $v->sub_category_name : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{sub_cate_id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{sub_cate_id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $rows['data'] = $data;
        return response()->json($rows, 200);
        //  dd($data);
    }
    public function removeCategory(Request $request)
    {
        $data['category_id'] = $request->id;
        $data['status'] = 3;
        DB::table('category')->where('category_id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function removeAds(Request $request)
    {
        $data['id'] = $request->id;
        $data['status'] = 3;
        DB::table('ads')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function removeHashTag(Request $request)
    {
        $data['has_tag_id'] = $request->id;
        $data['status'] = 3;
        DB::table('has_tag')->where('has_tag_id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function removeInSubCategory(Request $request)
    {
        $data['in_sub_cate_id'] = $request->id;
        $data['status'] = 3;
        DB::table('insubcategory')->where('in_sub_cate_id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function removeSubCategory(Request $request)
    {
        $data['sub_cate_id'] = $request->id;
        $data['status'] = 3;
        DB::table('sub_category')->where('sub_cate_id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}
