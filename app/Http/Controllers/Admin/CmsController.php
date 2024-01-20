<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Session;
class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page','cms-pages');

        $cmsPages = CmsPage::get()->toArray();
        // dd($cmsPages);
        return view('admin.pages.cms-pages')->with(compact('cmsPages'));
        //with passed the CmsPages Array
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CmsPage $cmsPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id=null)
    {
        Session::put('page','cms-pages');
      if($id==""){
        $title="ADD CMS Page";
        $cmspage=new CmsPage;
        $message="CMS Page Added successfully";
      }else{
        $title="Edit CMS Page";
        $cmspage=CmsPage::find($id);
        $message="CMS Page Updated successfully";
      }
      if($request->isMethod('POST')){
        $data=$request->all();
        //print
        $rules=[
            'title'=>'required',
            'url'=>'required',
            'description'=>'required',

        ];
        $customMessages=[
            'title.required'=>'Page Title is required',
            'url.required'=>'Page url is required',
            'description.required'=>'Page description is required',

        ];
        $this->validate($request,$rules,$customMessages);
        $cmspage->title=$data['title'];
        $cmspage->url=$data['url'];
        $cmspage->description=$data['description'];
        $cmspage->meta_title=$data['meta_title'];
        $cmspage->meta_description=$data['meta_description'];
        $cmspage->meta_keywords=$data['meta_keywords'];
        $cmspage->status=1;
        $cmspage->save();
        return redirect('admin/cms-page')->with('success_message',$message);
      }
      return view('admin.pages.add_edit_cmspage')->with(compact('title','cmspage'));
      // pass korlam cmpage
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        Session::put('page','cms-pages');
        if($request->ajax()){
            $data=$request->all();
            // echo"<pre>";
            // print_r($data); die;
            if($data['status']=='Active'){
                $status=0;
            }else{
                $status=1;
            }
            CmsPage::where('id',$data['page_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'page_id'=>$data['page_id']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //delete
        CmsPage::where('id',$id)->delete();
        return redirect()->back()->with('success_message','CMS Page delete successfuly');
    }
}