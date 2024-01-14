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
use App\Models\Gallary;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Console\Command;
class PostController extends Controller
{
    protected $frontend_url;
    protected $live_path;
    protected $default_time_zone;
    protected $localTime;
    public function __construct()
    {
        $this->frontend_url       = config(key: 'app.FRONTEND_HOST_NAME');
        $this->live_path          = config(key: 'app.FRONTEND_STROAGE');
        $this->default_time_zone  = config(key: 'app.timezone');
        $this->localTime          = date("Y-m-d H:i:s");
    }
    public function gamesPostInsert(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumbnail' => 'required',
        ]);
        if (!empty($request->file('thumbnail'))) {
            $thumbnail = $request->file('thumbnail');
            $fileName = Str::random(20);
            $ext = strtolower($thumbnail->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $thumbnail->move(public_path('/backend/files/'), $upload_url);
        } else {
            $chkUrl     = DB::table('games')->where('id', $request->id)->first();
            $upload_url = !empty($chkUrl) ? $chkUrl->thumbnail : "";
        }
        $data['user_id']     = Auth::id();
        $data['name']        = !empty($request['name']) ? $request['name'] : "";
        $data['slug']        = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['name'])));
        $data['description'] = !empty($request['description']) ? $request['description'] : "";
        $data['category_id'] = !empty($request['category_id']) ? $request['category_id'] : "";
        $data['sortingNum']  = !empty($request['sortingNum']) ? $request['sortingNum'] : "";
        $data['source']      = !empty($request['source']) ? $request['source'] : "";
        $data['status']      = !empty($request['status']) ? (int)$request['status'] : 0;
        $data['thumbnail']   = !empty($upload_url) ? $upload_url : "";
        if (empty($request->id)) {
            DB::table('games')->insertGetId($data);
        } else {
            DB::table('games')->where('id', $request->id)->update($data);
        }
        //dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function gallaryInsert(Request $request)
    {
        if (!empty($request->file('files'))) {
            foreach ($request->file('files') as $file) {
                $thumbnail = $file; //$request->file('thumbnail');
                $fileName = Str::random(20);
                $ext = strtolower($thumbnail->getClientOriginalExtension());
                $path = $fileName . '.' . $ext;
                $uploadPath = '/backend/files/'; //"/home/futurege/public_html/fgames/public/"; $this->live_path
                $upload_url = $uploadPath . $path;
                $thumbnail->move(public_path('/backend/files/'), $upload_url);
                $data['thumbnail'] = $upload_url;
                $data['user_id']   = $request->user_id;
                $data['status']    = $request->status;
                DB::table('gallary')->insert($data);
            }
        }
        return response()->json("upload");
        //  dd($request->all());
    }
    public function postInsert(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'title' => 'required',
            'video_upload' => 'required',
        ]);
        if (!empty($request->file('thumbnail'))) {
            //====================== For Live  ===========================
            $thumbnail_upload = $request->file('thumbnail');
            $fileName = Str::random(20);
            $ext = strtolower($thumbnail_upload->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $file_url = $uploadPath . $path;
            $target = "/home/futurege/public_html/fgames/public/";
            $file_tmp = $_FILES['thumbnail']['tmp_name'];
            move_uploaded_file($file_tmp, $target . $file_url);
            //====================== For Live End ===========================
            //====================== For Localhost  ===========================
            /*
            $thumbnail = $request->file('thumbnail');
            $fileName = Str::random(20);
            $ext = strtolower($thumbnail->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $thumbnail->move(public_path('/backend/files/'), $upload_url);
        */
            //====================== For Localhost End ===========================
        }
        //dd($upload_url);For LIVE 
        if (!empty($request->file('video_upload'))) {
            $video_upload = $request->file('video_upload');
            $fileName = Str::random(20);
            $ext = strtolower($video_upload->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/video/';
            $video_url = $uploadPath . $path;
            $target = "/home/futurege/public_html/fgames/public/";
            $file_tmp = $_FILES['video_upload']['tmp_name'];
            move_uploaded_file($file_tmp, $target . $video_url);
        }
        /*
        if (!empty($request->file('video_upload'))) {
            $video_upload = $request->file('video_upload');
            $fileName = Str::random(20);
            $ext = strtolower($video_upload->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $video_upload->move(public_path('/backend/files/'), $upload_url);
        }
        */
        $data['user_id']     = !empty($request['user_id']) ? $request['user_id'] : ""; //Auth::id();
        $data['title']       = !empty($request['title']) ? $request['title'] : "";
        $data['description'] = !empty($request['description']) ? $request['description'] : "";
        $data['entry_date']  = date("Y-m-d");
        $data['type']        = 1; //Normal Post
        $data['slug']        = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['title'])));
        $data['status']      = !empty($request['status']) ? (int)$request['status'] : 0;
        $data['thumbnail']   = !empty($file_url) ? $file_url : "";
        $data['video_upload'] = !empty($video_url) ? $video_url : "";
        $post_id             = DB::table('video_post')->insertGetId($data);
        $categoryStr         =  !empty($request['category_id']) ? $request['category_id'] : "";
        $hastagStr           =  !empty($request['has_tag_id']) ? $request['has_tag_id'] : "";
        // Category Insert 
        $exload_data = explode(",", $categoryStr);
        foreach ($exload_data as $key => $v) {
            $values[] = [
                'post_id'     => $post_id,
                'category_id'  => $v,
                'created_at'  => date('Y-m-d-H:i:s'),
            ];
        }
        DB::table('category_history')->insert($values);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'video_upload' => 'required',
        ]);
        if (!empty($request->file('thumbnail'))) {
            //====================== For Live  ===========================
            $thumbnail_upload = $request->file('thumbnail');
            $fileName = Str::random(20);
            $ext = strtolower($thumbnail_upload->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $file_url = $uploadPath . $path;
            $target = "/home/futurege/public_html/fgames/public/";
            $file_tmp = $_FILES['thumbnail']['tmp_name'];
            move_uploaded_file($file_tmp, $target . $file_url);
            //====================== For Live End ===========================
            //====================== For Localhost  ===========================
            /*
            $thumbnail = $request->file('thumbnail');
            $fileName = Str::random(20);
            $ext = strtolower($thumbnail->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $thumbnail->move(public_path('/backend/files/'), $upload_url);
        */
            //====================== For Localhost End ===========================
        }
        //dd($upload_url);For LIVE 
        if (!empty($request->file('video_upload'))) {
            $video_upload = $request->file('video_upload');
            $fileName = Str::random(20);
            $ext = strtolower($video_upload->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/video/';
            $video_url = $uploadPath . $path;
            $target = "/home/futurege/public_html/fgames/public/";
            $file_tmp = $_FILES['video_upload']['tmp_name'];
            move_uploaded_file($file_tmp, $target . $video_url);
        }
        /*
        if (!empty($request->file('video_upload'))) {
            $video_upload = $request->file('video_upload');
            $fileName = Str::random(20);
            $ext = strtolower($video_upload->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $video_upload->move(public_path('/backend/files/'), $upload_url);
        }
        */
        $post_id = $request['post_id'];
        $row     = DB::table('video_post')->where('post_id', $post_id)->first();
        $data['user_id']     = !empty($request['user_id']) ? $request['user_id'] : "";
        $data['title']       = !empty($request['title']) ? $request['title'] : "";
        $data['description'] = !empty($request['description']) ? $request['description'] : "";
        $data['slug']        = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['title'])));
        $data['entry_date']  = date("Y-m-d");
        $data['status']      = !empty($request['status']) ? (int)$request['status'] : 0;
        $data['thumbnail']   = !empty($file_url) ? $file_url : $row->thumbnail;
        $data['video_upload'] = !empty($video_url) ? $video_url :  $row->video_upload;
        DB::table('video_post')->where('post_id', $request['post_id'])->update($data);
        if (!empty($request['category_id'])) {
            $str      =  !empty($request['category_id']) ? $request['category_id'] : "";
            $exload_data = explode(",", $str);
            foreach ($exload_data as $key => $v) {
                $row =  DB::table('category_history')->where('category_id', $v)->where('post_id', $post_id)->delete();
                $values[] = [
                    'post_id'     => $post_id,
                    'category_id'  => $v,
                    'created_at'  => date('Y-m-d-H:i:s'),
                ];
            }
            DB::table('category_history')->insert($values);
        }
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function livepostInsert(Request $request)
    {
        //dd($request->all());
        $this->default_time_zone;
        $this->validate($request, [
            //'title'        => 'required',
            'user_id'      => 'required',
            'video_upload' => 'required',
        ]);
        /*
        if (!empty($request->file('thumbnail'))) {
            $thumbnail = $request->file('thumbnail');
            $fileName = Str::random(20);
            $ext = strtolower($thumbnail->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $thumbnail->move(public_path('/backend/files/'), $upload_url);
        }
        //dd($upload_url);
        */
        //dd($chkPoint);
        $data['user_id']     = $request['user_id'];
        $data['datetime']    = $request->datetime;
        $data['title']       = !empty($request['title']) ? $request['title'] : "";
        $data['source']      = !empty($request['source']) ? $request['source'] : "";
        $data['slug']        = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['title'])));
        $data['description'] = !empty($request['description']) ? $request['description'] : "";
        $data['schedule_time']   = !empty($request['schedule_time']) ? $request['schedule_time'] : "";
        $data['schedule_date']   = date("Y-m-d H:i:s", strtotime("{$request['schedule_date']} {$request['schedule_time']}"));
        $data['entry_date']  = date("Y-m-d");
        $data['type']        = 2; //Normal Post
        $data['status']      = !empty($request['status']) ? (int)$request['status'] : 0;
        $data['thumbnail']   = !empty($upload_url) ? $upload_url : "";
        //dd($data);
        $file_directory = "/home/fansgame/public_html/vdosrv/media/" . $request['user_id']; //Live
        //$file_directory = public_path("media/" . $request['user_id']); // Local
        //$cmd = "F:/xampp/htdocs/app/ff/bin/ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 \"{$file_directory}/{$request['video_upload']}\""; // Local
        $cmd = "/usr/local/bin/ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 '{$file_directory}/{$request['video_upload']}'"; //Live
        $process = Process::fromShellCommandline($cmd);
        $response = array();
        $error = "";
        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            $error = $exception->getMessage();
        }
        //$process->run();
        if (!$process->isSuccessful()) {
            $response['error'] = 1;
            $response['message'] = "<b>Video input file has error or not MP4 format. Operation not successfull.</b>\n\n <small>{$error}</small>";
            return response()->json($response, 200);
        }
        $data['durations']  = trim($process->getOutput()); //trim(\system($cmd));
        $chkPoint =  DB::table('video_post')->where('user_id', $request['user_id'])->orderBy('create_at', 'desc')->limit(1)->first();
        if (!empty($chkPoint)) {
            $sec = strtotime($chkPoint->schedule_date) + $chkPoint->durations;
            $cur_sec = strtotime($data['schedule_date']);
            if ($sec > $cur_sec) {
                $response['error'] = 1;
                $response['message'] = "Time mis match. Schedule time must be greater than " . date("Y-m-d H:i:s", $sec + 1);
                return response()->json($response, 200);
            }
        }
        $post_id = DB::table('video_post')->insertGetId($data);
        $cmd = "mv {$file_directory}/{$request['video_upload']} {$file_directory}/video_{$post_id}.mp4";
        $process = Process::fromShellCommandline($cmd);
        $process->run();
        //rename("{$file_directory}/{$request['video_upload']}", "{$file_directory}/video_{$post_id}.mp4");
        $updata['video_upload'] =  "{$request['user_id']}/video_{$post_id}.mp4";
        $updata['file_name'] = $request['video_upload'];
        DB::table('video_post')->where('post_id', $post_id)->update($updata);
        $response = [
            'data' => $data,
            'error' => 0,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function postUpdateLive(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'source' => 'required',
        ]);
        /*
        if (!empty($request->file('thumbnail'))) {
            $thumbnail = $request->file('thumbnail');
            $fileName = Str::random(20);
            $ext = strtolower($thumbnail->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/files/';
            $upload_url = $uploadPath . $path;
            $thumbnail->move(public_path('/backend/files/'), $upload_url);
        }
        //dd($upload_url);
        if (!empty($request->file('video_upload'))) {
            $video_upload = $request->file('video_upload');
            $fileName = Str::random(20);
            $ext = strtolower($video_upload->getClientOriginalExtension());
            $path = $fileName . '.' . $ext;
            $uploadPath = '/backend/video/';
            $video_url = $uploadPath . $path;
            $video_upload->move(public_path('/backend/video/'), $video_url);
        }
        */
        //dd($request->all());
        $post_id = $request['post_id'];
        $row     = DB::table('video_post')->where('post_id', $post_id)->first();
        $data['user_id']     = $request['user_id'];
        $data['title']       = !empty($request['title']) ? $request['title'] : "";
        $data['description'] = !empty($request['description']) ? $request['description'] : "";
        $data['source']      = !empty($request['source']) ? $request['source'] : "";
        $data['schedule_time']   = !empty($request['schedule_time']) ? $request['schedule_time'] : "";
        $data['schedule_date']   = date("Y-m-d", strtotime($request['schedule_date']));
        $data['durations']   = !empty($request['durations']) ? $request['durations'] : "";
        $data['entry_date']  = date("Y-m-d");
        $data['slug']        = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['title'])));
        $data['status']      = !empty($request['status']) ? (int)$request['status'] : 0;
        $data['thumbnail']   = !empty($upload_url) ? $upload_url : $row->thumbnail;
        $data['video_upload'] = !empty($video_url) ? $video_url :  $row->video_upload;
        DB::table('video_post')->where('post_id', $request['post_id'])->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editPostId($id)
    {
        $row                    = Post::checkPostRow($id);
        $data['images']         = !empty($row->thumbnail) ? $this->frontend_url . $row->thumbnail : "";
        $data['user_id']        = !empty($row->user_id) ? $row->user_id : "";
        $data['post_id']        = !empty($row->post_id) ? $row->post_id : "";
        $data['title']          = !empty($row->title) ? $row->title : "";
        $data['datetime']       = !empty($row->datetime) ? $row->datetime : "";
        $data['source']         = !empty($row->source) ? $row->source : "";
        $data['durations']      = !empty($row->durations) ? $row->durations : "";
        $data['schedule_date']  = !empty($row->schedule_date) ? $row->schedule_date : "";
        $data['schedule_time']  = !empty($row->schedule_time) ? $row->schedule_time : "";
        $data['description']    = !empty($row->description) ? $row->description : "";
        $data['video_upload']   = !empty($row->video_upload) ? $this->frontend_url . $row->video_upload : "";
        $data['status']         = !empty($row->status) ? $row->status : 0;
        $response = [
            'data'      => $data,
            'message'   => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editGallaryId($id)
    {
        $row                    = Gallary::checkGallaryRow($id);
        $data['user_id']        = !empty($row->user_id) ? $row->user_id : "";
        $data['id']             = !empty($row->id) ? $row->id : "";
        $data['status']         = !empty($row->status) ? $row->status : 0;
        $response = [
            'data'      => $data,
            'message'   => 'success'
        ];
        return response()->json($response, 200);
    }
    public function findMultipleThumnail($id)
    {
        $data           = Gallary::multipleThumnail($id);
        $response = [
            'data'      => $data,
            'message'   => 'success'
        ];
        return response()->json($response, 200);
    }
    public function deleteThumbnail(Request $request)
    {
        $data           = Gallary::multipleThumnailDelete($request->id);
        $response = [
            'data'      => $data,
            'message'   => 'success'
        ];
        return response()->json($response, 200);
    }
    public function editGamesId($id)
    {
        $data = Post::checGamesRow($id);
        // dd($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function dueReport(Request $request)
    {
        $data = Post::duereport($request->all());
        $sum = 0;
        foreach ($data as $v) {
            $sum += $v->due_amount;
        }
        // dd($data);
        $response = [
            'data' => $data,
            'total_sum' => $sum,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function dueReportMoney(Request $request)
    {
        $data = Post::duereportMoney($request->all());
        $sum = 0;
        foreach ($data as $v) {
            $sum += $v->due_amount;
        }
        // dd($data);
        $response = [
            'data' => $data,
            'total_sum' => $sum,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function profitReport(Request $request)
    {
        $data = Post::profitreport($request->all());
        $sum = 0;
        foreach ($data as $v) {
            $sum += $v->profit;
        }
        // dd($data);
        $response = [
            'data' => $data,
            'total_sum' => $sum,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function profitReportMoney(Request $request)
    {
        $data = Post::profitreportMoney($request->all());
        //dd($data);
        $sum = 0;
        foreach ($data as $v) {
            $sum += $v->profit;
        }


        $fees = 0;
        foreach ($data as $v) {
            $fees += $v->fees;
        }


        $tdue = 0;
        foreach ($data as $v) {
            $tdue += $v->due_amount;
        }

       // dd($tdue);
        // dd($data);
        $response = [
            'data' => $data,
            'total_fees' => number_format($fees,2),
            'total_sum' => number_format($sum,2),
            'total_due' => number_format($tdue,2),
            'totalTransaction' => count($data),
            'message' => 'success'
        ];


        return response()->json($response, 200);
    }
    public function profitReportOthers(Request $request)
    {
        $data = Post::profitReportOther($request->all());
        // dd($data);
        $sum = 0;
        foreach ($data as $v) {
            $sum += $v->profit;
        }
        // dd($data);
        $response = [
            'data' => $data,
            'total_sum' => $sum,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function deReportOthers(Request $request)
    {
        $data = Post::profitReportOther($request->all());
        // dd($data);
        $sum = 0;
        foreach ($data as $v) {
            $sum += $v->due_amount;
        }
        // dd($data);
        $response = [
            'data' => $data,
            'total_sum' => $sum,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function tradehistory()
    {
        $data = Post::tradehistyorylist();
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function limitPost()
    {
        $data       = Post::postLimit();
        $totalTrade = Post::totalTrade();
        $totalusers = Post::totalUsers();
        $totalwithd = Post::totalwithdraw();
        $totalDeposit = Post::totaldeposit();
        $response   = [
            'data'       => $data,
            'totalTrade' => $totalTrade,
            'totalusers' => $totalusers,
            'to_withdraw' => $totalwithd,
            'totalDeposit' => $totalDeposit,
            'message'    => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getTotalCount()
    {
        $totalusers         = Post::totalUsers();
        $totalCustomer      = Post::totalCustomers();
        $totalProfit        = Post::totalProfit();
        $totalDue           = Post::totalDue();
        $response   = [
            'totalusers'    => $totalusers,
            'totalCustomer' => $totalCustomer,
            'totalProfit'   => $totalProfit,
            'totalDue'      => $totalDue,
            'message'    => 'success'
        ];
        return response()->json($response, 200);
    }
    public function getGallaryList(Request $request)
    {
        $users = Gallary::filterGallaryList($request->all());
        // dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['status']     =
                $sdata['name']       = !empty($v->name) ? $v->name : '-';
            $sdata['user_id']    = $v->user_id;
            $sdata['actions']    = Helper::sprint('<button class="edit" data-id="{user_id}"><i class="fas fa-edit"></i></button>', $sdata);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getLivePostList(Request $request)
    {
        $users = Post::filterLivePostList($request->all());
        //dd($users);
        $data = array();
        //echo $this->localTime;
        $firstDateTime       = $this->localTime;
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            $sdata['user_id']    = !empty($v->name) ? $v->name . ' [ID:' . $v->id . ']' : '-';
            $sdata['title']      = !empty($v->title) ? $v->title : '-';
            $sdata['schedule_date']  = !empty($v->title) ? $v->schedule_date : '-';
            $sdata['durations']      = !empty($v->durations) ? gmdate("H:i:s", $v->durations) . "(" . $v->durations . ")"  : '-';
            $db_time_value       = substr($v->datetime, 0, -2);
            $secondDateTime      = date('Y-m-d H:i:s', strtotime($db_time_value));
            $diff    = abs(strtotime($secondDateTime) - strtotime($firstDateTime));
            $lsts['live_status'] = 1;
            /*
            if($firstDateTime > $secondDateTime){
                DB::table('video_post')->where('post_id',$v->post_id)->update($lsts);
                $sdata['datetime']   = '<span class="badge bg-success">Live Publish Done</span></span>';
            }else{
                $sdata['datetime']   = "{$days} days, {$hours} hours, {$minuts} minuts, {$seconds} seconds"; 
            }
            */
            $sdata['post_id']    = $v->post_id;
            if ($v->type == 1) {
                $sdata['type']   = "General Post";
            } else {
                $sdata['type']   = "Live";
            }
            $sdata['sitelink']     = $this->frontend_url . $v->video_upload;
            $sdata['entry_date']   = date("d-m-Y", strtotime($v->entry_date));
            $sdata['actions']      = Helper::sprint('<button class="edit" data-id="{post_id}"><i class="fas fa-edit"></i></button>
                                    <button class="del" data-id="{post_id}"><i class="fa-solid fa-trash"></i></button>', $sdata);
            /*
            $sdata['actions']      = Helper::sprint('<button class="edit" data-id="{post_id}"><i class="fas fa-edit"></i></button>
                                     <button class="del" data-id="{post_id}"><i class="fa-solid fa-trash"></i></button>
                                     <i class="fas fa-video"></i><a href="{sitelink}" target="_blank">&nbsp;SEEN VIDEOS</a>', $sdata);
            */
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function getPostList(Request $request)
    {
        $users = Post::filterPostList($request->all());
        //dd($users);
        $data = array();
        foreach ($users['data'] as $key => $v) {
            if ($v->status == 0) {
                $sdata['status'] = '<span class="badge bg-danger">Inactive</span></span>';
            } elseif ($v->status == 1) {
                $sdata['status'] = '<span class="badge bg-success">Active</span></span>';
            }
            // $sdata['category_name']= !empty($v->category_name) ? $v->category_name : '-';
            $sdata['title']        = !empty($v->title) ? $v->title : '-';
            $sdata['post_id']      = $v->post_id;
            if ($v->type == 1) {
                $sdata['type']   = "General Post";
            } else {
                $sdata['type']   = "Live";
            }
            // $sdata['video_upload'] = Helper::sprint('<video controls width="80">
            // <source src="{video_upload}" type="video/mp4" /></video>', $v); 
            $sdata['sitelink']     = $this->frontend_url . $v->video_upload; //url($v->video_upload); //Helper::sprint('<a href="'.$v->video_upload.'" target="_blank">Seen</a>');
            $sdata['entry_date']   = date("d-m-Y", strtotime($v->entry_date));
            $sdata['actions']      = Helper::sprint('<button class="edit" data-id="{post_id}"><i class="fas fa-edit"></i></button>
                                     <button class="del" data-id="{post_id}"><i class="fa-solid fa-trash"></i></button>
                                     <i class="fas fa-video"></i><a href="{sitelink}" target="_blank">&nbsp;SEEN VIDEO</a>', $sdata);
            $data[] = $sdata;
        }
        $users['data'] = $data;
        return response()->json($users, 200);
        //  dd($data);
    }
    public function removePost(Request $request)
    {
        $data['post_id'] = $request->id;
        $data['status'] = 3;
        DB::table('video_post')->where('post_id', $request->id)->update($data);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function categoryRemove(Request $request)
    {
        DB::table('category_history')->where('category_id', $request->id)->delete();
        $response = [
            'data' => "Remove",
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function htagRemove(Request $request)
    {
        DB::table('hastag_history')->where('htag_history_id', $request->id)->delete();
        $response = [
            'data' => "Remove",
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function selectedCategoryList($id)
    {
        $data = Post::postVideoCategory($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
    public function selectedHTagList($id)
    {
        $data = Post::postVideoHasTag($id);
        $response = [
            'data' => $data,
            'message' => 'success'
        ];
        return response()->json($response, 200);
    }
}
