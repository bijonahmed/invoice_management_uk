<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
class DepositController extends Controller
{
   
    public function depositList(Request $request)
    {
        $users = Deposit::filterDepositList($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-primary">Pending</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Approved</span></span>';
            } elseif ($v->status == 2) {
                $sdata['status'] = '<span class="badge bg-danger">Cancel</span></span>';
            }

            if ($v->payment_type == 1) {
                $sdata['payment_method'] = '<span>Crypto</span>';
            } elseif ($v->payment_type == 2) {
                $sdata['payment_method'] = '<span>Bank</span>';
            } 

            if ($v->payment_type == 1) {
                $sdata['details'] = $v->wallet_name;
            } elseif ($v->payment_type == 2) {
                $sdata['details'] =  $v->sortname.'/'.$v->bank_name;
            } 

            $sdata['amount']             = !empty($v->amount) ? '$'.$v->amount : '-';
            $sdata['username']           = !empty($v->username) ? $v->username : '-';
            $sdata['created_at']         = !empty($v->created_at) ? $v->created_at : '-';
            $sdata['id']                 = !empty($v->id) ? $v->id : '-';
            $sdata['actions']            = Helper::sprint('<button class="edit" data-id="{id}"><i class="fa fa-check"></i>&nbsp;Approved</button>
                                                           <button class="del" data-id="{id}"><i class="fa fa-close"></i>&nbsp;Cancel</button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }

    public function approvedDeposit(Request $request)
    {
        $data['id']         = $request->id;
        $data['approved_by']= (int) Auth::user()->id;
        $data['status'] = 1;
        DB::table('deposit')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function cancelDeposit(Request $request)
    {
        $data['id']     = $request->id;
        $data['approved_by']= (int) Auth::user()->id;
        $data['status'] = 2;
        DB::table('deposit')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}