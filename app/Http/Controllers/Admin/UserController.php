<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Hash;
use Session;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UserModel;
use App\Models\UserAddressModel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $data = [];

    public function index()
    {
        // get all the users
        $model = new UserModel();
        $model->getVars();

        $this->data['users'] = $model::where('user_id', '!=', 1)->get();
        $this->data['model'] = $model;
        $this->data['page_title'] = 'Manage Users'; //page title

        return view('admin.users.index')->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new UserModel();
        $model->getVars();
        $this->data['page_title'] = 'Add User'; //page title
        $this->data['model'] = $model;
        return view('admin.users.create')->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $User = new UserModel;

        $validator = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required|min:2|max:30|regex:/(^[A-Za-z ]+$)+/',
            'last_name' => 'required|max:30|regex:/(^[A-Za-z ]+$)+/',
            'user_name' => 'required|min:2|max:30|unique:' . $User->table . ',user_name,NULL,user_id,deleted_at,NULL',
            'email' => 'required|email|unique:' . $User->table . ',email,NULL,user_id,deleted_at,NULL',
            'password' => 'required|min:6',
            'mobile' => 'Numeric',
            'role' => 'required',
            'city' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'state' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'country' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'zip_code' => 'Numeric',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Storing user details
            $User->first_name = $request->input('first_name');
            $User->user_name = $request->input('user_name');
            $User->last_name = $request->input('last_name');
            $User->salutation = $request->input('salutation');
            $User->email = $request->input('email');
            $User->password = Hash::make($request->input('password'));
            $User->mobile = $request->input('mobile');
            $User->role_id = $request->input('role');
            $User->status = $request->input('status');
            $User->created_at = date('Y-m-d H:i:s');

            if ($User->save()) {

                // Storing user Address details
                if ($request->input('address1') != '' && $request->input('city') != '' && $request->input('state') != '' && $request->input('country') != '') {
                    $UserAddress = new UserAddressModel;
                    $UserAddress->user_reg_id = $User->user_id;
                    $UserAddress->address1 = $request->input('address1');
                    $UserAddress->address2 = $request->input('address2');
                    $UserAddress->city = $request->input('city');
                    $UserAddress->state = $request->input('state');
                    $UserAddress->country = $request->input('country');
                    if ($request->input('zip_code') != '') {
                        $UserAddress->zip_code = $request->input('zip_code');
                    }
                    $UserAddress->save();
                }
                Session::flash('flash_message', 'User added successfully!');
                return redirect('admin/users');
            }
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
        $id = (int)$id;
        if ($id == '' || $id < 0)
            return redirect(url('admin/users'));

        $model = UserModel::find($id);
        $model->getVars();
        $this->data['page_title'] = 'Details of ' . $model->first_name; //page title
        $this->data['model'] = $model;
        return view('admin.users.show')->with($this->data);
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
        if ($id == '' || $id < 0)
            return redirect(url('admin/users'));

        $model = UserModel::find($id);
        $model->getVars();
        $this->data['page_title'] = 'Edit User - ' . $model->first_name; //page title
        $this->data['model'] = $model;
        return view('admin.users.edit')->with($this->data);
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
        //
        $User = UserModel::find($id);

        $validator = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required|min:2|max:30|regex:/(^[A-Za-z ]+$)+/',
            'last_name' => 'required|max:30|regex:/(^[A-Za-z ]+$)+/',
            'user_name' => 'required|min:2|max:30|unique:' . $User->table . ',user_name,' . $id . ',user_id,deleted_at,NULL',
            'email' => 'required|email|unique:' . $User->table . ',email,' . $id . ',user_id,deleted_at,NULL',
            'password' => 'min:6',
            'mobile' => 'Numeric',
            'role' => 'required',
            'city' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'state' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'country' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'zip_code' => 'Numeric',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Storing user details
            $User->first_name = $request->input('first_name');
            $User->user_name = $request->input('user_name');
            $User->last_name = $request->input('last_name');
            $User->salutation = $request->input('salutation');
            $User->email = $request->input('email');
            if ($request->input('password') != "") {
                $User->password = Hash::make($request->input('password'));
            }
            $User->mobile = $request->input('mobile');
            $User->role_id = $request->input('role');
            $User->status = $request->input('status');
            $User->updated_at = date('Y-m-d H:i:s');

            if ($User->update()) {

                // Storing user Address details
                $UserAddress = UserAddressModel::where('user_reg_id', $id)->first();

                if ($UserAddress) {
                    // Updating user Address details
                    $UserAddress->address1 = $request->input('address1');
                    $UserAddress->address2 = $request->input('address2');
                    $UserAddress->city = $request->input('city');
                    $UserAddress->state = $request->input('state');
                    $UserAddress->country = $request->input('country');
                    $UserAddress->zip_code = $request->input('zip_code');
                    $UserAddress->save();
                } else {
                    // Storing user Address details
                    if ($request->input('address1') != '' && $request->input('city') != '' && $request->input('state') != '' && $request->input('country') != '') {
                        $UserAddress = new UserAddressModel;
                        $UserAddress->user_reg_id = $id;
                        $UserAddress->address1 = $request->input('address1');
                        $UserAddress->address2 = $request->input('address2');
                        $UserAddress->city = $request->input('city');
                        $UserAddress->state = $request->input('state');
                        $UserAddress->country = $request->input('country');
                        if ($request->input('zip_code') != '') {
                            $UserAddress->zip_code = $request->input('zip_code');
                        }
                        $UserAddress->save();
                    }
                }

                Session::flash('flash_message', 'User Updated successfully!');
                return redirect('admin/users');
            }
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
        $User = UserModel::find($id);
        $User->delete();

        $UserAddress = UserAddressModel::where('user_reg_id', $id)->first();
        if ($UserAddress) {
            $UserAddress->delete();
        }


        // redirect
        Session::flash('flash_message', 'User deleted successfully!');
        return redirect('admin/users');
    }
}
