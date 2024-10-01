<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Validator;

// Model(s)
use App\Models\CustomerTypeMasterModel;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new CustomerTypeMasterModel();
        
        $this->data['model'] = $model;
        $this->data['customer_type'] = $model::all();
        $this->data['page_title'] = 'Manage Member Types';
        return view('admin.customer_type.index')->with($this->data); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new CustomerTypeMasterModel();
        
        $this->data['model'] = $model;
        $this->data['page_title'] = 'Add Member Type';
        return view('admin.customer_type.create')->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_type = new CustomerTypeMasterModel;      

        $validator = Validator::make($request->all(), [
            'name' =>'required|min:2|max:60|unique:'.$customer_type->table.',name,NULL,id,deleted_at,NULL',
            'status' => 'required' 
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Storing customer type details             
            $customer_type->name= $request->input('name'); 
            $customer_type->status= $request->input('status'); 
            $customer_type->save();  
          
            Session::flash('flash_message', 'Member type added successfully!');
            return redirect('admin/customer_type');
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
        if(($id = intval($id)) <= 0)
            return redirect('admin/banks');

        $model = CustomerTypeMasterModel::find($id);
        
        $this->data['model'] = $model;
        $this->data['page_title'] = 'Edit Member Type - '. $model->name;
        return view('admin.customer_type.edit')->with($this->data); 
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
        $customer_type = CustomerTypeMasterModel::find($id);      

        $validator = Validator::make($request->all(), [
            'name' =>'required|min:2|max:60|unique:'.$customer_type->table.',name,'.$id .',id,deleted_at,NULL',
            'status' => 'required' 
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Storing customer type details             
            $customer_type->name= $request->input('name'); 
            $customer_type->status= $request->input('status'); 
            $customer_type->save();  
          
            Session::flash('flash_message', 'Member type updated successfully!');
            return redirect('admin/customer_type');
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
        $customer_type = CustomerTypeMasterModel::find($id);
        $customer_type->delete();
        
        Session::flash('flash_message', 'Member type deleted successfully!');
        return redirect('admin/customer_type');
    }
}
