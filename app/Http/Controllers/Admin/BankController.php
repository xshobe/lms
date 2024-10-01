<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BankMasterModel;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all banks
        $model=new BankMasterModel();
        $this->data['bank'] = $model::all();
        $this->data['model'] = $model;
        $this->data['page_title']='Manage Banks';//page title         

        // load the view and pass the banks

        return view('admin.banks.index')->with($this->data);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model=new BankMasterModel();
        $this->data['page_title']='Add Bank';//page title         
        $this->data['model']=$model;
        return view('admin.banks.create')->with($this->data); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Bank = new BankMasterModel;      

        $validator = Validator::make($request->all(), [
       
        'bank_name' =>'required|min:2|max:60|unique:'.$Bank->table.',bank_name,NULL,id,deleted_at,NULL',  
        'status' => 'required' 
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Storing Bank details             
            $Bank->bank_name= $request->input('bank_name'); 
            $Bank->status= $request->input('status'); 
            $Bank->save();  
          
            Session::flash('flash_message', 'Bank added successfully!');
            return redirect('admin/banks');
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
        $id=(int)$id;    
        if($id=='' || $id<0)
        return redirect(url('admin/banks'));

        $model=BankMasterModel::find($id);
        
        $this->data['page_title']='Edit Bank- '.$model->bank_name;//page title 
        $this->data['model'] =$model;    
        return view('admin.banks.edit')->with($this->data);    
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
        $Bank = BankMasterModel::find($id);      

        $validator = Validator::make($request->all(), [
       
        'bank_name' =>'required|min:2|max:60|unique:'.$Bank->table.',bank_name,'.$id .',id,deleted_at,NULL',  
        'status' => 'required' 
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Storing Bank details             
            $Bank->bank_name= $request->input('bank_name'); 
            $Bank->status= $request->input('status'); 
            
            if($Bank->update()){
                Session::flash('flash_message', 'Bank updated successfully!');
                return redirect('admin/banks');

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
         $Bank = BankMasterModel::find($id);
         $Bank->delete();

       
        // redirect
        Session::flash('flash_message', 'Bank deleted successfully!');
        return redirect('admin/banks');
    }
}
