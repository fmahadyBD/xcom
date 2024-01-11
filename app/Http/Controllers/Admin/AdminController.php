<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;




class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo"<pre>";print_r($data);


            $rules = [

                'email' => 'required|email|max:255',
                'password' => 'required:max:30',
            ];

            $customMessages = [
                'eamil.required' => "email is requried",
                'email.email' => 'valied is required',
                'password.required' => 'password is required',
            ];
            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {

                return redirect("admin/dashboard");
            } else {
                return redirect()->back()->with("error_message", "invalied Email of Password");
            }
        }
        return view('admin.login');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //check if current password is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                //check if new password and confirmed password is same
                if ($data['new_password'] == $data['confirmed_password']) {
                    //update new password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'your new password hass been updated!');
                } else {
                    return redirect()->back()->with('error_message', 'your new password is  and comfirmed password is not match');
                }
            } else {
                return redirect()->back()->with('error_message', 'your current password is incorrect');
            }
        }

        return view('admin.update_password');
    }




    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();

        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }
    public function updateDetails(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();

            echo "<pre>";
            print_r($data);


            $rules = [

                // 'admin_name'=>'required|alpha|max:255',
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                //alpha will not accept the spaces
                // 'admin_mobile' => 'required| numeric|max:11|min:10',
                'admin_mobile' => 'required| numeric|digits:11',
                //digit
                //13th tutorial
            ];
            // search it in validation
            $customMessages = [
                'admin_name.required' => "Name is requried",
                'admin_name.regex' => "Valid Name is requried",
                // 'admin_name.alpha'=>'valied Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'valied Mobile is required',
                'admin_mobile.max' => 'Mobile number is not correct',
                'admin_mobile.min' => 'valied Mobile is required',
            ];
            $this->validate($request, $rules, $customMessages);
            //pdate Amdin Details

            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile']]);
            return redirect()->back()->with('success_message', 'your new details hass been updated!');
        }
        return view('admin.update_details');
    }
}
