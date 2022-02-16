<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Guestbook;
use App\Models\Province;

use Illuminate\Support\Facades\Validator;
use Datatables;

class GuestbookController extends Controller
{
    private $title;
    private $subbread;

    public function __construct(){
        $this->title = "Guest Book";
        $this->subbread = route('admin.guestbook.index');
    }

    public function index(Request $request){
        return view('admin.guest-book.index', [
            'title' => $this->title,
            'page' => 'Index',
            'breadcrumb' => $this->subbread,
        ]);
    }

    public function index_data(Request $request){
        $data = Guestbook::with(['province', 'city'])->orderBy('created_at', 'DESC')->get();
        if($request->type == "datatable"){
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $edit_btn = '<a href="' . route("admin.guestbook.view_edit", $data->id) . '" class="btn btn-success" title="Edit guestbook entry: ' . $data->id . '"><i class="fas fa-pencil-alt"></i></a>';
                $view_btn = '<a href="' . route("admin.guestbook.view", $data->id) . '" class="btn btn-primary" title="View guestbook entry details: ' . $data->id . '"><i class="fas fa-search"></i></a>';
                $delete_btn = '<a href="#" onclick="delete_guestbook(\'' . route("admin.guestbook.submit_delete", $data->id) . '\')" class="btn btn-danger" title="Delete guestbook entry from ' . $data->first_name . ' ' . $data->last_name . '"><i class="fas fa-trash"></i></a>';
                return $view_btn . ' ' . $edit_btn . " " . $delete_btn;
            })
            ->make(true);
        } else {
            return $data->toJson();
        }
    }

    public function add_new(){
        $province_data = Province::all();
        return view('admin.guest-book.add',[
            'title' => $this->title,
            'page' => 'Add New Guestbook Entry',
            'breadcrumb' => $this->subbread,
            'province' => $province_data,
        ]);
    }

    public function add_submit(Request $request){
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {
            $data = Guestbook::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'organization' => $request->organization,
                'address' => $request->address,
                'message' => $request->message,
                'province_code' => $request->province,
                'city_code' => $request->city,
            ]);

            return redirect(route('admin.guestbook.index'))->with([
                'status_message' => 'Success adding new guestbook entry as ' . $request->first_name . ' ' . $request->last_name,
            ]);
        }
    }

    public function view_edit($id){
        $data = Guestbook::where('id', $id)->first();
        $province_data = Province::all();
        if($data){
            return view('admin.guest-book.add', [
                'title' => $this->title,
                'page' => 'Edit Guest Book Entry',
                'breadcrumb' => $this->subbread,
                'data' => $data,
                'province' => $province_data,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function edit_submit($id, Request $request){
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {
            $data = Guestbook::where('id', $id)->first();
            $data->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'organization' => $request->organization,
                'address' => $request->address,
                'province_code' => $request->province,
                'city_code' => $request->city,
                'message' => $request->message,
            ]);

            return redirect(route('admin.guestbook.index'))->with([
                'status_message' => 'Success editing guestbook entry',
            ]);
        }
    }

    public function view($id){
        $data = Guestbook::where('id', $id)->first();
        $province_data = Province::all();
        return view('admin.guest-book.add', [
            'title' => $this->title,
            'page' => 'View Details',
            'breadcrumb' => $this->subbread,
            'data' => $data,
            'province' => $province_data,
        ]);
    }

    public function delete_entry($id){
        $data = Guestbook::where([
            'id' => $id,
        ])->first();
        if($data){
            $data->delete();
            return json_encode([
                'status_message' => 'Success deleting guestbook entry from '. $data->first_name . ' ' . $data->last_name,
            ]);
        } else {
            return redirect(route('admin.guestbook.index'))->with([
                'status_message' => 'Failed deleting guestbook entry from '. $data->first_name . ' ' . $data->last_name,
            ]);
        }
    }

    public function validation(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'organization' => 'string|nullable|max:255',
            'address' => 'string|nullable|max:255',
            'message' => 'required|string|max:255',
            'province' => 'required|integer|exists:province,code',
            'city' => 'required|integer|exists:city,code',
        ]);
        return $validator;
    }
}
