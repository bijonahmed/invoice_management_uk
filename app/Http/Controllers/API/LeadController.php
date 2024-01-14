<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Lead;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
class LeadController extends Controller
{
    public function saveLead(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'status' => 'required',
        ]);
        $data = Lead::addEditLead($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editLeadId($id)
    {
        $data = Lead::checkLeadRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getLeadList(Request $request)
    {
        $users = Lead::filterLeadList($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['full_name']    = !empty($v->full_name) ? $v->full_name : '-';
            $sdata['company_name'] = !empty($v->company_name) ? $v->company_name : '-';
            $sdata['address']      = !empty($v->address) ? $v->address : '-';
            $sdata['email']        = !empty($v->email) ? $v->email : '-';
            $sdata['phone_number'] = !empty($v->phone_number) ? $v->phone_number : '-';
            $sdata['create_at'] = date("d-m-Y",strtotime($v->create_at));
            $sdata['actions']      = Helper::sprint('<button class="edit" data-id="{lead_id}"><i class="fas fa-edit"></i></button>
                                     <button class="del" data-id="{lead_id}"><i class="fa-solid fa-trash"></i></button>
                                     <button class="customer" data-id="{lead_id}"><i class="fa-solid fa-share"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function removeLead(Request $request)
    {
        
        $data['lead_id'] = $request->id;
        $data['status'] = 3;
        DB::table('lead')->where('lead_id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}
