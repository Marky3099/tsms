<?php

namespace App\Controllers;
use App\Libraries\Hash;
use App\Models\User;


class Pages extends BaseController
{
    public function __construct(){
        helper(['url','form']);
    }
    public function index()
    {
        
        $data['main'] = 'pages/homep';
        return view("pages/home",$data);
    }
   
   
    public function about()
    {
        $data['main'] = 'pages/about';
        return view("pages/home",$data);
    }

    public function login()
    {
        // $data['main'] = 'pages/login';
        return view("pages/login");
    }

    public function check()
    {
        helper(['form']);
        
        $validation =  \Config\Services::validation();
        $session = session();
        // login Validation
        $validation = $this->validate([
            'email'    => [
                'rules'=>'required|valid_email|is_not_unique[users.email]',
                'errors'=>[
                    'required'=>'Email is Required',
                    'valid_email'=>'Enter a valid Email',
                    'is_not_unique'=>'Email does not exist'
                ]
            ],
            'password' => [
                'rules'=>'required|min_length[3]',
                'errors'=>[
                    'required'=>'Password is Required',
                    'min_length'=>'Password must have at least 3 characters'
                ]
            ]
        ]);

        if (!$validation) {
            $data['main'] = 'pages/login';
            $data['validation'] = 'Wrong Email/Password';
            return view('pages/login_temp',$data,['validation1' => $this->validator]);
            
        }else {
            $user = new User();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user_info = $user->where('email', $email)->first();

            if ($user_info) {
                $pass = $user_info['password'];

                $check_password = password_verify($password,$pass);
               
                if ($check_password) {
                    $getdata = [
                        'user_id' => $user_info['user_id'],
                        'username' => $user_info['name'],
                        'email' => $user_info['email'],
                        'address' => $user_info['address'],
                        'contact' => $user_info['contact'],
                        'position' => $user_info['position'],
                        'user_img' => $user_info['user_img'],
                        'password' => $user_info['password'],
                        'active' => $user_info['active'],
                        'isLoggedIn' => TRUE,
                    ];
                     if($user_info['active'] == 1){ 
                    $session->set($getdata);
                    return redirect()->to('dashboard');
                    }  else{
                        $data['main'] = 'pages/login';
                      $data['errorAcc'] = "Account Not Activated";
                      return view('pages/login_temp',$data);  
                    }
                }else{
                      $data['main'] = 'pages/login';
                      $data['errorMessage'] = "Wrong Password";
                      return view('pages/login_temp',$data);   
                }
            }
        }
    }
}
