<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;

class PublicModel extends Authenticatable
{

  public static function postVideoList()
  {
    return DB::table('video_post')->where('type', 2)->where('status', 1)->orderBy('post_id', 'desc')->get();
  }

  public static function allmodes()
  {
    $allmodels = DB::table('users')->select('id', 'slug')->where('role_id', 6)->where('status', 1)->orderBy('id', 'desc')->get();
    //print_r($allmodels);
    $vids = [];
    $json = '{
      "app": "live",
      "mode": "static",
      "edge": "./media/first.mp4",
      "name": "first"
    }';
    $vid = Json_decode($json, 1);
    $vid['post_id'] = rand(1, 999999);
    $vid['create_at'] = date('Ymd');

    $file_directory = "/home/fansgame/public_html/vdosrv/media/"; //Live
    //$file_directory = public_path("media/"); // Local

    foreach ($allmodels as $model) {
      $sql = "SELECT video_upload FROM video_post where user_id='{$model->id}' AND delete_status='1'";
      $postlist = DB::select($sql);

      foreach ($postlist as $v) {
        $file_path = "{$file_directory}{$v->video_upload}";
        if (file_exists($file_path)) {
          //unlink($file_path);
        }
      }

      //FROM video_post where user_id='{$model->id}' AND type=2 AND status='1' AND Date(schedule_date) <=NOW()
      $sql = "SELECT post_id, video_upload,create_at FROM video_post where user_id='{$model->id}' AND type=2 AND status='1' AND delete_status='0' AND schedule_date BETWEEN  (NOW() - INTERVAL 3600 SECOND)  AND NOW() ORDER BY create_at DESC LIMIT 1";
      //echo $sql;
      $post = DB::select($sql);

      $online = 0;
      if (!empty($post[0])) {
        $online = 1;
        $v = [
          'edge' => "./media/" . $post[0]->video_upload,
          'name' => $model->slug,
          'create_at' => $post[0]->create_at,
          'post_id' => $post[0]->post_id
        ];
        $vids[] = array_merge($vid, $v);
      }
      $sql = "UPDATE users SET online='{$online}' where id='{$model->id}'";
      DB::select($sql);
    }

    $json = json_encode($vids);
    file_put_contents("test.json", $json);
    return $json;
  }
}
