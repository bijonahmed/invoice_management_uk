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
use App\Models\Withdraw;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
class WithdrawalController extends Controller
{
   
    public function withdrawalList(Request $request)
    {
        $users = Withdraw::filter($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-primary">Pending</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Approved</span></span>';
            } elseif ($v->status == 2) {
                $sdata['status'] = '<span class="badge bg-danger">Cancel</span></span>';
            }
           
            $sdata['amount']             = !empty($v->amount) ? '$'.$v->amount : '-';
            $sdata['username']           = !empty($v->username) ? $v->username : '-';
            $sdata['created_at']         = !empty($v->create_at) ? $v->create_at : '-';
            $sdata['id']                 = !empty($v->id) ? $v->id : '-';
            $sdata['actions']            = Helper::sprint('<button class="edit" data-id="{id}"><i class="fa fa-check"></i>&nbsp;Approved</button>
                                                           <button class="del" data-id="{id}"><i class="fa fa-close"></i>&nbsp;Cancel</button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }

    public function approved(Request $request)
    {
        $data['id']        = $request->id;
        $data['approved_by']= (int) Auth::user()->id;
        $data['status'] = 1;
        DB::table('withdrawal')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function cancel(Request $request)
    {
        $data['id']     = $request->id;
        $data['approved_by']= (int) Auth::user()->id;
        $data['status'] = 2;
        DB::table('withdrawal')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}