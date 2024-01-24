<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use Auth;
use Validator;
use Hash;
use Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        // This Crate a seection for show the active file.
        return view('admin.dashboard');
        // return a bade file for view
    }
    public function login(Request $request)
    {

        Session::put('page', 'login');
        if ($request->isMethod('post')) {
            // Route is match. that's why we need to check method are post or get. it saparete get and post
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // Give some rules for validation of input
            $rules = [

                'email' => 'required|email|max:255',
                'password' => 'required:max:30',
            ];

            $customMessages = [
                'eamil.required' => "email is requried",
                'email.email' => 'valied is required',
                'password.required' => 'password is required',
            ];
            //this will print data in blade file error or success message. validate muust passed by whit(....,'message to show')
            $this->validate($request, $rules, $customMessages);

            // this is for set the cookies for remeber me function
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
            // Route is match. that's why we need to check method are post or get. it saparete get and post
            $data = $request->all();
            // Take data from submit the form through request
            //check if current password is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                // ',' means this is == for checking the password both are equal
                //check if new password and confirmed password is same
                if ($data['new_password'] == $data['confirmed_password']) {
                    // this means the two input fild data is match or not
                    //update new password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    // update the from by make the data as bcrypt formate. after new need to hash for decript
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

    // ------------>> this function for the custom.js file to retunr true or fale?
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

        // i am try to edit the admin details by separate two get,post method without use match
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
            // checked not need beacuse this is must define as a post from web
            $admin = Auth::guard('admin')->user();
            $id = $admin->id;
            if ($admin) {
                // check the admin in avelable
                // Call the updateDetails method on the Admin model with the $id parameter
                $admin->updateDetailsx($request, $id);
                // this is fnction to retunr true or false for customjs
                // check the current password and the same or not
            }
        }
        return redirect()->back()->with('success_message', 'true');
    }



    public function subAdmins()
    {

        Session::put('page', 'subadmins');
        $subadmins = Admin::where('type', 'subadmin')->get(); // it will call al the subadmin to subadmins array, it will pass to array for print the list of subadminsby tabel

        // what is the work of this function. this is actually retun the list of Subadmins. we need to give the permission
        // to subadmin can access edit,update,delete function or not by condition

        // use compact for pass the array to blade
        // $cmsPages = Admin::get()->toArray(); // comment it to prove it have not work in function or  in its balde
        //it will be Subadmin pages
        $subadmin_are_in_Adminrole_count = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_page'])->count();
        // dd($cmspagesModuleCont);
        if (Auth::guard('admin')->user()->type == 'admin') {
            $subadmin_access_module['subadmin_view_access'] = 1;
            $subadmin_access_module['subadmin_edit_access'] = 1;
            $subadmin_access_module['subadmin_full_access'] = 1;
            // make index of

        } else if ($subadmin_are_in_Adminrole_count == 0) {

            $messge = "This feature is restricted for you!";
            // this block for the check any record are exists in the admin_role table or not
            return redirect('/admin/dashboard')->with('error_message', $messge);

            // if there have no permission to edit
        } else {
            $subadmin_access_module = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_page'])->first()->toArray();
        }
        // dd($subadmin_access_module); //working fine

        return view('admin.subadmins.subadmins')->with(compact('subadmins',  'subadmin_access_module'));
        // 'cmsPages',
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
            // if there have idthen find by this id of the suadmin to
            $message = "SubadminUpdated successfully";
        } else {
            // Load form for adding subadmin
            $title = "ADD Subadmin ";
            $subadmin = new Admin();
            $message = "Subadmin Added successfully";
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
        // this fnction for custom.js to check the email are already in database or not
    }

    public function checkmobilenumber(Request $request)
    {
        // call ervey data data from request
        $data = $request->all();
        $mobile = $data['smobile'];
        $count = strlen($mobile);
        if ($count > 10) {
            return "true";
        } else {
            return "false";
        }
        // this fnction for custom.js to check the mobile number digits are 10 more not not!
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

            //['cms_page']['full_access'] or ['subadmin']['subadmin_view_access'] other, are from the blade file to save it. this condition are under the post
            if (isset($data['subadmin']['subadmin_view_access'])) {
                $cms_page_Subadmin_view_access     = $data['subadmin']['subadmin_view_access'];
            } else {
                $cms_page_Subadmin_view_access     = 0;
            }
            if (isset($data['subadmin']['subadmin_edit_access'])) {
                $cms_page_Subadmin_edit_access = $data['subadmin']['subadmin_edit_access'];
                //name="subadmin[edit] from blade file
            } else {
                $cms_page_Subadmin_edit_access = 0;
            }
            if (isset($data['subadmin']['subadmin_full_access'])) {
                $cms_page_Subadmin_full_access = $data['subadmin']['subadmin_full_access'];
            } else {
                $cms_page_Subadmin_full_access = 0;
            }
            //role is array
            //-> is index of role that is the column name of database
            //right side of the =, is the varibale that we define in preious line.
            //
            $role = new AdminsRole;
            // it create new AdminRole database row to sotre new one, we delete rows of privous recored by delete
            $role->subadmin_id    = $id;
            $role->module    = 'cms_page';
            $role->view_access    =  $cms_page_view;
            $role->edit_access    = $cms_page_edit;
            $role->full_access    = $cms_page_full_access;
            $role->subadmin_view_access  = $cms_page_Subadmin_view_access;
            $role->subadmin_edit_access   = $cms_page_Subadmin_edit_access;
            $role->subadmin_full_access   = $cms_page_Subadmin_full_access;
            $role->save();

            $message = "Subadmin Role Update sccessfully";
            return redirect()->back()->with('success_message', $message);
        }
        // SubadminRoles array will recived as role to check database this is checked or not form databse
        // compact is the passing process controller ot blade file. we recive this by name in blade file
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
        // this will cheecked the view file is exits or not
        if (view()->exists('admin.subadmins.update_subadmin_details')) {
            return view('admin.subadmins.update_subadmin_details', compact('id', 'admin'));
        } else {
            abort(404); // or handle it in a way that fits your application
        }
    }
}
