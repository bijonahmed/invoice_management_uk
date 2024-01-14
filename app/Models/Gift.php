<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;
class Gift extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $table = "gifts";
    protected $fillable = [
        'name',
        'amount',
        'url_link',
        'status',
    ];
    public static function addEditGift($request)
    {
        $data['name']         = !empty($request['name']) ? $request['name'] : "";
        $data['amount']       = !empty($request['amount']) ? $request['amount'] : "";
        $data['url_link']     = !empty($request['url_link']) ? $request['url_link'] : "";
        $data['status']       = !empty($request['status']) ? (int)$request['status'] : 0;
        if (!empty($request['id'])) {
            DB::table(with(new static)->getTable())->where('id', $request['id'])->update($data);
        } else {
            DB::table(with(new static)->getTable())->insert($data);
        }
        return $data;
    }
    public static function editGiftId($id)
    {
        return DB::table(with(new static)->getTable())->where('id', $id)->first();
    }
    public static function fitterGifts($data = array())
    {
        //dd($data);
        $cond = '';
        if (!empty($data['gift_name'])) {
            $cond .= " AND gifts.name LIKE '%" . $data['gift_name'] . "%'";
        }
        $st = '0,1';
        if (isset($data['status'])) {
            $st = $data['status'];
        }
        $cond .= " AND gifts.status IN({$st})";
        $cond .= " ORDER BY gifts.id DESC";
        $limit = $data['length']; //10
        if (!empty($data['page'])) {
            $start = $limit * ($data['page'] - 1);
        }
        $sqld = "SELECT *
              FROM `gifts` 
              WHERE 1 " . $cond;
        $sqld .= " LIMIT $start,$limit";
        //echo $sqld;exit; 
        $results = DB::select($sqld);
        $sqlt = "SELECT count(*)total FROM `gifts` WHERE 1 {$cond}";
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