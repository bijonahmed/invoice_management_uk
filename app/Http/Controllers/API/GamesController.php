<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Games;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
class GamesController extends Controller
{
    public function getGamesData(Request $request)
    {
        $users = Games::filterList($request->all());
        $data = array();
        foreach ($users['data'] as $key => $v) {
            $sdata['id']            = !empty($v->id) ? $v->id : '-';
            $sdata['name']          = !empty($v->category_name) ? $v->name : '-';
            $sdata['category_name'] = !empty($v->category_name) ? $v->category_name : '-';
            $sdata['create_at']     = !empty($v->create_at) ? date("Y-m-d", strtotime($v->create_at)) : '-';
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['actions']          = Helper::sprint('<button class="edit" data-id="{id}"><i class="fas fa-edit"></i></button><button class="del" data-id="{id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
    }
    public function removeGames(Request $request){
        $data['id'] = $request->id;
        $data['status'] = 3;
        DB::table('games')->where('id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}
