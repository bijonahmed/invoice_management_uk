<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Category;
use App\Models\Gift;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;

class GitftController extends Controller
{

    public function saveGifts(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'amount'        => 'required',
            'status'        => 'required',
        ]);
        $data = Gift::addEditGift($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }

    public function editGiftId($id)
    {
        $data = Gift::editGiftId($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }

   
    public function giftsList(Request $request)
    {
        $users = Gift::fitterGifts($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['name']          = !empty($v->name) ? $v->name : '-';
            $sdata['url_link']      = !empty($v->url_link) ? $v->url_link : '-';
            $sdata['amount']        = !empty($v->amount) ? $v->amount : '-';
            $sdata['actions']       = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }

    public function removeGifts(Request $request)
    {
      
        $data['id']     = (int)$request->id;
        $data['status'] = 3;
        DB::table('gifts')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}