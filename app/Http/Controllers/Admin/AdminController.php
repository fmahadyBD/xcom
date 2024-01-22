<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminsRole;
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
        // check the current password and given password are same or not
        $data = $request->all();
        // this funtion is not define as post mehton that's why we cheeck every data and find the email


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
        // it will print the error in from

        if ($request->isMethod('post')) {
            $admin = Auth::guard('admin')->user();
            $id = $admin->id;
            if ($admin) {
                // check the admin in avelable

                // Call the updateDetails method on the Admin model with the $id parameter
                $admin->updateDetailsx($request, $id);
                // check the current password and the same or nott
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
        // this is the section

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


            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'smobile' => 'required|numeric|digits:11',
                'image' => 'image',
                'password' => 'required',
            ];

            $customMessages = [
                'name.required' => "Name is required",
                'name.regex' => "Valid Name is required",
                'smobile.required' => 'Mobile is required',
                'smobile.numeric' => 'Valid Mobile is required ',
                'smobile.digits' => '11 digit Mobile is required',
                'image.image' => 'Valid Image is required',
                'password.required' => "Password is required",
            ];

            $data = $request->all();

            // Handle file upload from the Admin Model
            if ($request->hasFile('image')) {
                $imageUrl = Admin::subadminimageUpload($request);
            } else {
                $imageUrl = $subadmin->image; // Make sure $subadmin is defined
            }
            // this is for added password into the hash
            $hashedPassword = bcrypt($data['password']);
            $subadmin->password = $hashedPassword;


            // Save other fields
            $subadmin->name = $data['name'];
            $subadmin->email = $data['email'];
            $subadmin->mobile = $data['smobile'];
            // $subadmin->password = $data['password'];
            $subadmin->type = 'subadmin';
            $subadmin->status = 1;
            $subadmin->image = $imageUrl;
            // status and type defult save it can change by admin


            $this->validate($request, $rules, $customMessages);
            // print the validate mesasge


            try {
                $result = $subadmin->save();
                return redirect()->back()->with('success_message', 'Added Sussessfully');
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        return view('admin.subadmins.add_edit_subadmin')->with(compact('title', 'subadmin'));
    }


    public function checkemail(Request $request)
    {
        // check the current password and given password are same or not
        $data = $request->all();
        // by this funtion we get the email

        //  theflow-> when type it. cause the email try to find. the url hit to web web call the check pass by post. and this is the functioon
        $email = $data['email'];
        // $email = $request->input('email');
        $userExists = Admin::where('email', $email)->exists();


        if ($userExists) {
            return "true";
        } else {
            return "false";
        }
    }

    public function checkmobilenumber(Request $request)
    {
        // call ervey data data from request
        $data = $request->all();


        //
        $mobile = $data['smobile'];

        $count = strlen($mobile);


        if ($count > 10) {
            return "true";
        } else {
            return "false";
        }
    }


    // update the role:
    public function updateRole($id, Request $request)
    {
        // this will be show title on subadmin
        $subadminRoles = AdminsRole::where('subadmin_id', $id)->get()->toArray();
        $subadminDetails = Admin::where('id', $id)->first()->toArray();
        $title = "Update " . $subadminDetails['name'] . " Subadmin Roles/Permission";

        //   dd($subadminRoles);
        // dd to check the
        if ($request->isMethod('post')) {

            $data = $request->all();
            // for debug the code
            // echo "<pre>";
            // print_r($data);
            // die;
            // delete the privios value


            // dynamic
            // foreach ($data as $key => $value) {
            //     if (isset($value['view'])) {
            //         $view = $value['view'];
            //     } else {
            //         $view = 0;
            //     }
            //     if (isset($value['edit'])) {
            //         $edit = $value['edit'];
            //     } else {
            //         $edit = 0;
            //     }
            //     if (isset($value['full_access'])) {
            //         $full_access = $value['full_access'];
            //     } else {
            //         $full_access = 0;
            //     }
            // }
            // // make dynamic
            // $role = new AdminsRole;
            // $role->subadmin_id    = $id;
            // $role->module    = $key;
            // $role->view_access    =  $view;
            // $role->edit_access    = $edit;
            // $role->full_access    = $full_access;
            // $role->save();


            AdminsRole::where('subadmin_id', $id)->delete();
            // added the new value
            // check thee cms_page view hase value?
            if (isset($data['cms_page']['view'])) {
                $cms_page_view = $data['cms_page']['view'];;
            } else {
                $cms_page_view = 0;
            }
            if (isset($data['cms_page']['edit'])) {
                $cms_page_edit = $data['cms_page']['edit'];
            } else {
                $cms_page_edit = 0;
            }
            if (isset($data['cms_page']['full_access'])) {
                $cms_page_full_access = $data['cms_page']['full_access'];
            } else {
                $cms_page_full_access = 0;
            }

            $role = new AdminsRole;
            $role->subadmin_id    = $id;
            $role->module    = 'cms_page';
            $role->view_access    =  $cms_page_view;
            $role->edit_access    = $cms_page_edit;
            $role->full_access    = $cms_page_full_access;
            $role->save();



            $message = "Subadmin Role Update sccessfully";
            return redirect()->back()->with('success_message', $message);
        }

        return view('admin.subadmins.update_role')->with(compact('title', 'id', 'subadminRoles'));
    }



    // Update the subadmin details
    public function updateSubadminDetailes($id, Request $request)
    {

        $admin = Admin::find($id);

        if ($request->isMethod('post')) {

            $data = $request->validate([
                'name' => 'required|string',
                'mobile' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust this based on your requirements
                'password' => 'nullable|string|min:6',
            ]);

            $data = $request->all();

            if ($request->hasFile('image')) {
                $imageurl = Admin::subadminimageUpload($request);
            } else {
                $imageurl = Admin::find($id)->image;
            }

            if ($request->filled('password')) {

                $hashedPassword = bcrypt($data['password']);
                $admin->password = $hashedPassword;
            }
            $admin->name = $data['name'];
            $admin->email = Admin::find($id)->email;
            $admin->mobile = $data['mobile'];
            $admin->image = $imageurl;
            $admin->status = 1;
            $admin->type = 'subadmin';
            try {
                $admin->save();
                return redirect()->back()->with('success_message', 'Update Subadmin data');
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        
        if (view()->exists('admin.subadmins.update_subadmin_details')) {
            return view('admin.subadmins.update_subadmin_details', compact('id', 'admin'));
        } else {
            abort(404); // or handle it in a way that fits your application
        }
    }
}
