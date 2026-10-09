<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Studentlog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;

class StudentLogInController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        if ($user->session_id && Session::getId() != $user->session_id) {
          
            \Session::getHandler()->destroy($user->session_id);
        }
        $user->session_id = Session::getId();
        $user->save();
    }

    // public function index()
    // {
       
    //     if (Auth::guard('student')->check()) {
    //          $tests = DB::table('tests')
    //                  ->select('id','test')
    //                       ->paginate(5);
    //         return redirect('/student.dashboard')->with(array('tests'=>$tests));
    //     }
    //     return view('student.login');
    // }
    
public function index()
{

    if (Auth::guard('student')->check()) {
        $tests = DB::table('tests')
                   ->select('id', 'test')
                   ->paginate(5);
        // Pass the $tests data to the 'student.dashboard' view
        return view('student.dashboard', compact('tests'));
    }
    return view('student.login');
}


    public function register()
    {
        return view('student.register');
    }

    public function forget_password()
    {
        return view('student.forget_password');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
          
        ];
        
//         $rules = [
//     'email' => ['required', 'string', 'email'],
//     'password' => ['required', 'string'],
//     'g-recaptcha-response' => ['required', 'captcha'], // Fix: separate 'required' and 'captcha'
// ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            foreach ($rules as $key => $value) {
                $errors[$key] = $validator->messages()->first($key);
            }
            return [
                'status' => 'error',
                'code' => 000,
                'message' => $errors,
                'data' => [],
            ];
        } else {
            $user = studentlog::where('email', '=', $request->email)->first();
            if($user){
               
                if(\Hash::check($request->password, $user->password)){
                  $request->session()->put('id', $user->id);
                    $request->session()->put('email', $user->email);
                    $this->authenticated($request, $user);
                    return [
                            'status' => 'success',
                            'code' => 111,
                            'message' => 'Logged in successfully.',
                            'data' => [],
                        ];

                }else{
                    return [
                            'status' => 'error',
                            'code' => 000,
                            'message' => 'Invalid credential.',
                            'data' => [],
                        ];
                }
            
        }else{
            return [
            
                'status' => 'error',
                'code' => 000,
                'message' => 'Invalid credential.',
                'data' => [],
            ];
        }
    }
}




    public function dashboard()
    {
        return view('student.slotbookingoption');
    }

    public function register_code(Request $request)
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:studentlogs'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = [];
            foreach ($rules as $key => $value) {
                $errors[$key] = $validator->messages()->first($key);
            }
            return [
                'status' => 'error',
                'code' => 000,
                'message' => $errors,
                'data' => [],
            ];
        } else {
            $data = [
                'name' => 'Student',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'show_password' => $request->password
            ];
            if (!empty($data)) {
                $res = DB::table('studentlogs')->insert($data);
                if ($res) {
                    return [
                        'status' => 'success',
                        'code' => 111,
                        'message' => 'User created successfully.',
                        'data' => [],
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'code' => 000,
                        'message' => 'Something went wrong.',
                        'data' => [],
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'code' => 000,
                    'message' => 'Data missing.',
                    'data' => [],
                ];
            }
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('student')->user();
        if ($user) {
            $user->session_id = null;
            $user->save();
        }

        Auth::guard('student')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('student/login');
    }
}
