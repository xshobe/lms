<?php
namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoanCategoriesModel;


class LoanCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // get all loan categories
        $model=new LoanCategoriesModel();
        $this->data['loan'] = $model::all();
        $this->data['model'] = $model;
        $this->data['page_title']='Manage Loan Categories';//page title         

        // load the view and pass theloan categories

        return view('admin.loancategories.index')->with($this->data);    
        
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model=new LoanCategoriesModel();
        $this->data['page_title']='Add Loan Category';//page title         
        $this->data['model']=$model;
        return view('admin.loancategories.create')->with($this->data); 
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
        $Loan = new LoanCategoriesModel;      

        $validator = Validator::make($request->all(), [
       
        'loan_title' =>'required|min:2|max:30|unique:'.$Loan->table.',title,NULL,id,deleted_at,NULL',  
        'status' => 'required' 
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Storing Loan Categories details             
            $Loan->title= $request->input('loan_title'); 
            $Loan->status= $request->input('status');  
            $Loan->created_at= date('Y-m-d H:i:s'); 
            $Loan->save();  
          
            Session::flash('flash_message', 'Loan Category added successfully!');
            return redirect('admin/loancategories');
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
        return redirect(url('admin/loancategories'));

        $model=LoanCategoriesModel::find($id);
        
        $this->data['page_title']='Edit Loan Category- '.$model->title;//page title 
        $this->data['model'] =$model;    
        return view('admin.loancategories.edit')->with($this->data);    
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
        $Loan =LoanCategoriesModel::find($id);      

        $validator = Validator::make($request->all(), [
        'loan_title' =>'required|min:2|max:30|unique:'.$Loan->table.',title,'.$id .',id,deleted_at,NULL',  
        'status' => 'required' 
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Storing user details             
            $Loan->title= $request->input('loan_title');  
            $Loan->status= $request->input('status');
            $Loan->updated_at= date('Y-m-d H:i:s');    
            if($Loan->update()){
                Session::flash('flash_message', 'Loan Category Updated successfully!');
                return redirect('admin/loancategories');
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
         $Loan = LoanCategoriesModel::find($id);
         $Loan->delete();

       
        // redirect
        Session::flash('flash_message', 'Loan Category deleted successfully!');
        return redirect('admin/loancategories');
    }
}
