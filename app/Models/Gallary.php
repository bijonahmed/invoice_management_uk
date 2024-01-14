<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;

class Gallary extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $table = "video_post";
    public static function checkGallaryRow($id)
    {
        $row =  DB::table('gallary')->where('user_id', $id)->first();
        return $row;
    }
    public static function multipleThumnail($id)
    {
        $row =  DB::table('gallary')->where('user_id', $id)->get();
        return $row;
    }
    public static function multipleThumnailDelete($id)
    {
        $rows = DB::table('gallary')->where('id', $id)->delete();
        return $rows;
    }
    public static function filterGallaryList($data = array())
    {
        //dd($data);
        $cond = '';
        if (!empty($data['txtField'])) {
            $cond .= " AND video_post.title LIKE '%" . $data['txtField'] . "%'";
        }
        //category_id
        if (!empty($data['category_id'])) {
            $cond .= " AND gallary.category_id='" . $data['category_id'] . "'";
        }
        $st = '0,1';
        if (isset($data['status'])) {
            $st = $data['status'];
        }
        $cond .= " AND gallary.status IN({$st})";
        $cond .= " GROUP BY gallary.user_id ORDER BY gallary.id DESC";
        $limit = $data['length']; //10
        if (!empty($data['page'])) {
            $start = $limit * ($data['page'] - 1);
        }
        $sqld = "SELECT gallary.*,users.name FROM `gallary`
               LEFT JOIN  users ON users.id=gallary.user_id WHERE 1 " . $cond;
        $sqld .= " LIMIT $start,$limit";
        // echo $sqld;exit; 
        $results = DB::select($sqld);
        $sqlt = "SELECT count(*)total FROM gallary
            WHERE 1 {$cond}";
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
