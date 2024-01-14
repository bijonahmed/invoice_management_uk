<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PublicModel;
use Illuminate\Support\Str;
use DB;
class PublicController extends Controller
{
    public function getVideoLists(){
        //$videos    = PublicModel::postVideoList();
       echo  $all_model = PublicModel::allmodes();
    }
    
    public function updateDeleteStatus($id){
        //0=defalut, 1=delete
        $data['delete_status'] = 1;
        $data['end_time']      = date("Y-m-d H:i:s");
        DB::table('video_post')->where('post_id', $id)->update($data);
        echo json_encode("successfully update");
       
    }
}
