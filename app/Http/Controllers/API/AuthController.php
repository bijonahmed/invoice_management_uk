<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;
use DB;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|email',
            'password'      => 'required',
            'c_password'    => 'required|same:password'
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully'
        ];
        return response()->json($response, 200);
    }
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {

            $response = [
                'success' => false,
                'message' => 'Unauthorised'
            ];
           // return response()->json($response);
            return response()->json($response, 401);
        }

        /*
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->status == 1) {
                $success['token'] = $user->createToken('MyApp')->plainTextToken;
                $success['name'] = $user->name;
                $response = [
                    'success' => true,
                    'data' => $success,
                    'message' => 'User login successfully'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Sorry, You cannot login. You contact the administrator'
                ];
            }
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorised'
            ];
            return response()->json($response);
        }
        */
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Auth::logout();
        return response()->json(
            [
                'message' => 'Logout successfully',
                'status' => 200
        ]);
    }

    
}
