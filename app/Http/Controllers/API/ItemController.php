<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Items;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
use Cart;
class ItemController extends Controller
{
    public function saveItem(Request $request)
    {
        $this->validate($request, [
            'item_name' => 'required',
            'unit_price'=> 'required',
            'unit'      => 'required',
            'status'    => 'required',
        ]);
        $data = Items::addEditItem($request->all());
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editItemId($id)
    {
        $data = Items::checkItemRow($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function addToCartItem(Request $request)
    {
            $this->validate($request, [
                'item_id'       => 'required',
                'unit'          => 'required',
                'unit_price'    => 'required',
            ]);
            $getItem = Items::checkItemRow($request->item_id);
            $data = array();
            $data['id']         = $request->item_id;
            $data['quantity']   = $request->unit;
            $data['name']       = $getItem->item_name;
            $data['price']      = $request->unit_price;
            //dd($data);
            Cart::add($data);
            $response = [
                'data' => $data,
                'message' => 'success'
            ];
            return response()->json($response, 200);
    }
    public function getItemHistory(){
        $data = Cart::getContent();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function deleteCartRow(Request $request)
    {
        Cart::remove($request->id, 0);
        $response = [
            'data' => $request->id,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
     public function allItems()
    {
        $data = Items::checkItems();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getItemList(Request $request)
    {
        $users = Items::filterItemist($request->all());
        //dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['item_name']    = !empty($v->item_name) ? $v->item_name : '-';
            $sdata['unit_price']   = !empty($v->unit_price) ? $v->unit_price : '-';
            $sdata['unit']         = !empty($v->unit) ? $v->unit : '-';
            $sdata['actions']      = Helper::sprint('<button class="edit" data-id="{item_id}"><i class="fas fa-edit"></i></button>
                                     <button class="del" data-id="{item_id}"><i class="fa-solid fa-trash"></i></button>', $v);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function removeItem(Request $request)
    {
        $data['item_id'] = $request->id;
        $data['status'] = 3;
        DB::table('items')->where('item_id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function checkItemName(Request $request){
        $row = Items::checkItemName($request->item_name);
        //dd($data);
        if (empty($row)) {
            $data['status'] = 0; //no category; 
        } else {
            $data['status'] = 1; //avialable category; 
        }
        return response()->json($data);
    }
}
