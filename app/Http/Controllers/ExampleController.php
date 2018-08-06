<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;

use Dingo\Api\Routing\Helpers;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Mail;

class ExampleController extends Controller
{
    use Helpers;
    
    protected $jwt;
    protected $auth;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function add(){
        //var_dump(User::all());
        $user = User::paginate(5);

        /*  发送邮件
        $content = '阿红色法律思考激发岁的法拉快速的佛教阿隆索的开放<a href="http://www.baidu.com">SBSBSSB</a>';
        $toMail = '1041811780@qq.com';
        Mail::raw($content, function($message) use ($toMail){
            $message->subject('title');
            $message->to($toMail);
        });
        */
        /**
         * 
        *$dispatcher = app('Dingo\Api\Dispatcher');
        *$token = JWTAuth::getToken();

        *echo $token;

        *$users = $dispatcher->get('/auth/isauth', ['token' => $token]);
        *var_dump($users);
        *exit;
         */

        $user = User::where('email', 'dk@163.com')->first();
        if($user){
            $user = User::where('email', 'resetpassword@163.com')->first();
        }
        JWTAuth::factory()->setTTL(1);
        $res = JWTAuth::fromUser($user);
        

        return $res;
        //throw new UnauthorizedHttpException('no auth');
        //return $user;//$this->response->item($user, new UserTransformer);
    }

    public function test(){
        return '123';
    }

    public function postLogin(Request $request){
        
        //$arr = array('email'=>'hwjwxn@163.com', 'password'=>'123456');
        //echo password_hash('123456',PASSWORD_BCRYPT,['cost' => 10]);
        //$hashedValue = '$2y$10$hSYAMCt8IrX1qjopj1mjxelJQG66a4RgPTSlk71yRD3qyDQQx2.5a';
        //var_dump(JWTAuth::attempt($arr));
        //JWTAuth::factory()->setTTL(5);
        //echo JWTAuth::factory()->getTTL();
        //var_dump(JWTAuth::user());

        /*$param = $request->only('email', 'password');
        //$users = DB::select('select * from users');
        //var_dump(auth());
        
        //echo $this->jwt->tokenById(123);
        
        if (! $token = $this->jwt->attempt($arr)) {
            return response()->json(['user_not_found'], 404);
        }

        
        return compact('token');
        //return response()->json(compact('token'));
        */
    }

    //
}
