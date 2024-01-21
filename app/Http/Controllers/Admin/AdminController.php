<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;
use image;


use Session;

use function Laravel\Prompts\alert;

// Sir this 'image' create the problem in this project. I


class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');


        return view('admin.dashboard');
    }
    public function login(Request $request)
    {


        Session::put('page', 'login');

        if ($request->isMethod('post')) {
            $data = $request->all();
            echo "<pre>";
            print_r($data);


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


                // Remember Admin Email & password with cookies
                if (isset($data['remember']) && !empty($data['remember'])) {
                    setcookie("email", $data['email'], time() + 3600);
                    setcookie("password", $data['password'], time() + 3600);
                } else {
                    setcookie("email", "");
                    setcookie("password", "");
                }


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

        Session::put('page', 'updatepassword');


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
    public function edit(Request $request)
    {

        Session::put('page', 'updatedetails');
        return view('admin.update_details');
    }


    public function updateDetails(Request $request)
    {

        Session::put('page', 'updatedetails');

        $rules = [

            // 'admin_name'=>'required|alpha|max:255',
            'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            //alpha will not accept the spaces
            // 'admin_mobile' => 'required| numeric|max:11|min:10',
            'admin_mobile' => 'required| numeric|digits:11',
            'admin_image' => 'image',
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
            'admin_image.image' => 'valied Image is required',
        ];
        // view('admin.update_details');
        $this->validate($request, $rules, $customMessages);
        if ($request->isMethod('post')) {
            $admin = Auth::guard('admin')->user();
            $id = $admin->id;
            if ($admin) {

                // Call the updateDetails method on the Admin model with the $id parameter
                $admin->updateDetailsx($request, $id);
            }
        }
        return redirect()->back()->with('success_message', 'true');
    }
    public function subAdmins()
    {
        Session::put('page', 'subadmins');
        $subadmins = Admin::where('type', 'subadmin')->get();
        // use compact for pass the array to blade
        return view('admin.subadmins.subadmins')->with(compact('subadmins'));
    }
    public function updateSubadminStatus(Request $request)
    {
        Session::put('page', 'cms-pages');
        if ($request->ajax()) {
            $data = $request->all();
            // echo"<pre>";
            // print_r($data); die;


            if ($data['status'] == 'Active' || $data['status'] == 'active') {
                $status = 0;
            } else {
                $status = 1;
            }

            Admin::where('id', $data['subadmin_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'subadmin_id' => $data['subadmin_id']]);
        }
    }
    public function deleteSubadminx($id)
    {

        // delete the sub admin
        Admin::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Subadmin delete successfuly');
    }
    public function deletesbadmin($id)
    {
        //delete
        Admin::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'CMS Page delete successfuly');
    }


    // add subadmin


    public function editSubadmin(Request $request, $id = null)
    {
        Session::put('page', 'cms-pages');

        if ($id) {
            // Load form for editing subadmin
            $title = "Edit Subadmin";
            $subadmin = Admin::find($id);
            $message = "SubadminUpdated successfully";
        } else {
            // Load form for adding subadmin
            $title = "ADD Subadmin ";
            $subadmin = new Admin();
            $message = "SubadminAdded successfully";
        }


        if ($request->isMethod('POST')) {
            $email = $request->input('email');

            // Check if email exists in the database
            $userExists = Admin::where('email', $email)->exists();
            // check the email is already in database or not

            if ($userExists) {
                // Email already exists, handle the response (e.g., show an error message)



               return response()->json(['exists' => true]);(['exists' => true, 'message' => 'Email already exists!']);
                // redirect()->back()->with('success_message', 'Added Sussessfully');
                // it is the response of the cuustom js to finding the email is exists or not
            }



       $rules = [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'mobile' => 'required|numeric|digits:11',
            'image' => 'image',
        ];

        $customMessages = [
            'name.required' => "Name is required",
            'name.regex' => "Valid Name is required",
            'mobile.required' => 'Mobile is required',
            'mobile.numeric' => 'Valid Mobile is required',
            'mobile.digits' => 'Valid Mobile is required',
            'image.image' => 'Valid Image is required',
        ];

        $this->validate($request, $rules, $customMessages);


            $data = $request->all();

            // Handle file upload
            if ($request->hasFile('image')) {
                $imageUrl = Admin::subadminimageUpload($request);
            } else {
                $imageUrl = $subadmin->image; // Make sure $subadmin is defined
            }

            // Save other fields
            $subadmin->name = $data['name'];
            $subadmin->email = $data['email'];
            $subadmin->mobile = $data['mobile'];
            $subadmin->password = $data['password'];
            $subadmin->type = 'subadmin';
            $subadmin->status = 1;
            $subadmin->image = $imageUrl;

            try {
                $result = $subadmin->save();
                return redirect()->back()->with('success_message', 'Added Sussessfully');
            } catch (\Exception $e) {
                dd($e->getMessage()); // Log or display the exception message
            }
        }

        return view('admin.subadmins.add_edit_subadmin')->with(compact('title', 'subadmin'));
    }


}
