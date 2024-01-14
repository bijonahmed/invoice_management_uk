<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Bank;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
class BankController extends Controller
{
    public function bankInsert(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'bank_name'  => 'required',
            'status'     => 'required',
          
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data['user_id']          = Auth::id();
        $data['country_id']       = !empty($request->country_id) ? $request->country_id : "";
        $data['bank_name']        = !empty($request->bank_name) ? $request->bank_name : "";
        $data['status']           = !empty($request['status']) ? (int)$request['status'] : 0;

        if (empty($request->id)) {
            DB::table('bank')->insertGetId($data);
        } else {
            DB::table('bank')->where('id', $request->id)->update($data);
        }
      
        $response = [
            'message' => 'Successfully insert',
        ];
        return response()->json($response);
    }
 
    public function tokenPackagesList(Request $request){

        $results = Bank::bankfilter($request->all());
        //dd($results);
        $data = array();
        foreach ($results['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['id']                    = $v->id;
            $sdata['bank_name']             = !empty($v->bank_name) ? $v->bank_name : '-';
            $sdata['country_name']          = !empty($v->country_name) ? $v->country_name : '-';
            $sdata['actions']               = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button>', $sdata);
            /*
            $sdata['actions']      = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button>
                                     <button class="del" data-id="{id}"><i class="fa-solid fa-trash"></i></button>', $sdata);
            */
            $data[] = $sdata;
        }
        $results['data'] = $data;
        return response()->json($results, 200);

    }

 
    public function editBank($id)
    {

        $data = Bank::checkBankRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }

    public function removeToken(Request $request)
    {
        DB::table('token_packages')->where('token_pack_id', $request->id)->delete();
        $response = [
            'data' => "Remove",
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}
