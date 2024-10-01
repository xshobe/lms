<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\RoleMasterModel;
use App\Models\AdminPrivilegesModel;



class RoleMasterController extends Controller
{
    public $data = [];


    public function index()
    {
        // get all the roles
        //where('id', '!=',1)->get()
        $this->data['roles'] = RoleMasterModel::where('id', '!=', 1)->get();
        $this->data['page_title'] = 'Manage Roles'; //page title

        // load the view and pass the roles

        return view('admin.roles.index')->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['page_title'] = 'Add Role'; //page title
        return view('admin.roles.create')->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Role = new RoleMasterModel;

        $validator = Validator::make($request->all(), [
            'role_name' => 'required|min:2|max:25|regex:/(^[A-Za-z ]+$)+/|unique:' . $Role->table . ',role_name,NULL,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $Role->role_name = $request->input('role_name');
            $Role->created_at = date('Y-m-d H:i:s');
            $Role->updated_at = NULL;
            $Role->save();
            Session::flash('flash_message', 'Role added successfully!');
            return redirect('admin/roles');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = (int)$id;
        if ($id == '' || (int)$id < 0)
            return redirect(url('admin/roles'));

        $Role = RoleMasterModel::find($id);

        $this->data['page_title'] = 'Edit - ' . $Role->role_name; //page title
        $this->data['role'] = $Role;
        return view('admin.roles.edit')->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Role = RoleMasterModel::find($id);
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|min:2|max:25|regex:/(^[A-Za-z ]+$)+/|unique:' . $Role->table . ',role_name,' . $id . ',id,deleted_at,NULL'

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $Role->role_name = $request->input('role_name');
            $Role->updated_at = date('Y-m-d H:i:s');
            $Role->update();
            Session::flash('flash_message', 'Role updated successfully!');
            return redirect('admin/roles');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $Role = RoleMasterModel::find($id);
        $Role->delete();

        // redirect
        Session::flash('flash_message', 'Role deleted successfully!');
        return redirect('admin/roles');
    }

    /**
     * Show the form to set access to the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAccess($id)
    {
        $Role = RoleMasterModel::find($id);
        $this->data['page_title'] = 'Access Matrix - ' . $Role->role_name; //page title
        $this->data['role'] = $Role;

        $this->data['checked_privilege_ids'] = array();
        $privileges = AdminPrivilegesModel::where('role_id', $id)->first();
        if (!empty($privileges)) {
            $this->data['checked_privilege_ids'] = unserialize($privileges->actions);
        }
        $this->data['privileges'] = \Config::get('constants.access');
        return view('admin.roles.access')->with($this->data);
    }

    public function setAccess(Request $request, $id)
    {
        $privilege_id = $request->input('privilege_id');

        $validator = Validator::make($request->all(), [
            'privilege_id' => 'required'
        ], [
            'privilege_id.required' => 'Role should have atleast one privilage'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $privilege_model = AdminPrivilegesModel::where('role_id', $id)->first();
        //pr(); die();


        if ($privilege_model) {
            $privilege_model->actions = serialize($privilege_id);
            $privilege_model->update();
            Session::flash('flash_message', 'Privilege updated successfully!');
        } else {
            $privilege_model = new AdminPrivilegesModel();
            $privilege_model->role_id = $id;
            $privilege_model->actions = serialize($privilege_id);
            $privilege_model->save();
            Session::flash('flash_message', 'Privilege added successfully!');
        }
        return redirect('admin/roles');
    }
}
