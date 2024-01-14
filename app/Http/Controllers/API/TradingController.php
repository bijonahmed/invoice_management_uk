<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Category;
use App\Models\Trading;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
class TradingController extends Controller
{
    public function mininghistory(Request $request)
    {
        $users = Trading::filterMiningList($request->all());
        //dd($users['data']);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-danger">Runing</span></span>';
            } elseif ($v->status == 2) {
                $sdata['status'] = '<span class="badge bg-success">Complete</span></span>';
            }
            $sdata['id'] = !empty($v->id) ? $v->id : '-';
            $sdata['mining_id'] = !empty($v->mining_id) ? $v->mining_id : '-';
            $sdata['username'] = !empty($v->username) ? $v->username : '-';
            $sdata['amount'] = !empty($v->amount) ? $v->amount : '-';
            $sdata['created_at'] = !empty($v->created_at) ? $v->created_at : '-';
            $sdata['ending_time'] = !empty($v->ending_time) ? $v->ending_time : '-';
            $sdata['duration'] = !empty($v->diff_hour) ? $v->diff_hour . "hour" : '-';
            $sdata['profi_percentage'] = !empty($v->profit_percentage) ? $v->profit_percentage : '-';
            $sdata['profit'] = !empty($v->profit) ? $v->profit : '-';
            $sdata['username'] = !empty($v->username) ? $v->username : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{id}"><i class="fa fa-search-plus"></i>&nbsp;</button>', $v);
            //<button class="edit" data-id="{id}"><i class="fa fa-check"></i>&nbsp;Approved</button>
            //<button class="del" data-id="{id}"><i class="fa fa-close"></i>&nbsp;Cancel</button>
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
    }
    public function cryptohistory(Request $request)
    {
        $users = Trading::filterCryptohistoryList($request->all());
        //dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            } elseif ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            }
            $sdata['id'] = !empty($v->id) ? $v->id : '-';
            $sdata['name'] = !empty($v->name) ? $v->name : '-';
            $sdata['crypto_wallet_address'] = !empty($v->crypto_wallet_address) ? $v->crypto_wallet_address : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{id}"><i class="fa fa-search-plus"></i>&nbsp;</button>', $v);
            //<button class="edit" data-id="{id}"><i class="fa fa-check"></i>&nbsp;Approved</button>
            //<button class="del" data-id="{id}"><i class="fa fa-close"></i>&nbsp;Cancel</button>
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function tradinghistory(Request $request)
    {
        $users = Trading::filterTradingList($request->all());
        //dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">WIN</span></span>';
            } elseif ($v->status == 2) {
                $sdata['status'] = '<span class="badge bg-danger">LOSS</span></span>';
            } elseif ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Review</span></span>';
            }
            if ($v->api_update_status == 2) {
                $sdata['api_update_status'] = '<span class="badge bg-danger">Failed</span></span>';
            } elseif ($v->api_update_status == 3) {
                $sdata['api_update_status'] = '<span class="badge bg-success">Complete</span></span>';
            }
            $sdata['trade_id'] = !empty($v->trade_id) ? $v->trade_id : '-';
            $sdata['username'] = !empty($v->username) ? $v->username : '-';
            $sdata['coin_code'] = !empty($v->coin_code) ? $v->coin_code : '-';
            $sdata['created_at'] = !empty($v->create_at) ? $v->create_at : '-';
            $sdata['id'] = !empty($v->id) ? $v->id : '-';
            $sdata['actions'] = Helper::sprint('<button class="edit" data-id="{id}"><i class="fa fa-search-plus"></i>&nbsp;</button>', $v);
            //<button class="edit" data-id="{id}"><i class="fa fa-check"></i>&nbsp;Approved</button>
            //<button class="del" data-id="{id}"><i class="fa fa-close"></i>&nbsp;Cancel</button>
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function updateCrypto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'crypto_wallet_address' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $data['id'] = (int) $request->id;
        $data['name'] = $request->name;
        $data['crypto_wallet_address'] = $request->crypto_wallet_address;
        $data['status'] = $request->status;
        DB::table('compay_crypto_wallet')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function updateTrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'fast_price' => 'required',
            'update_price' => 'required',
            'status' => 'required',
            'trade_types' => 'required',
            'trade_percent' => 'required',
            'trade_fee' => 'required',
            'es_profit' => 'required',
            'trade_profit' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $data['id'] = (int) $request->id;
        $data['fast_price'] = $request->fast_price;
        $data['update_price'] = $request->update_price;
        $data['status'] = $request->status;
        $data['trade_types'] = $request->trade_types;
        $data['trade_percent'] = $request->trade_percent;
        $data['trade_fee'] = $request->trade_fee;
        $data['es_profit'] = $request->es_profit;
        $data['trade_profit'] = $request->trade_profit;
        $data['approved_by'] = (int) Auth::user()->id;
        DB::table('trading')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function updateMining(Request $request)
    {
        $data['id'] = (int) $request->id;
        $data['amount'] = $request->amount;
        $data['profit_percentage'] = $request->profit_percentage;
        $data['status'] = (int) $request->status;
        $data['profit'] = $request->profit;
        $data['approved_by'] = (int) Auth::user()->id;
        DB::table('mining')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function traderow(Request $request)
    {
        $data = DB::table('trading')->where('id', $request->id)->first();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function miningRow(Request $request)
    {
        $data = DB::table('mining')->where('id', $request->id)->first();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function checkCryprtoRow(Request $request)
    {
        $data = DB::table('compay_crypto_wallet')->where('id', $request->id)->first();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}