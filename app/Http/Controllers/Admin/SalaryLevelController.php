<?php

namespace App\Http\Controllers\Admin;

use App\Models\SalaryLevelModel;
use Session;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalaryLevelController extends Controller
{
    public $data = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the Salary Level
        $model = new SalaryLevelModel();
        $this->data['Salary'] = $model::all();
        $this->data['model'] = $model;
        $this->data['page_title'] = 'Manage Salary Level'; //page title

        // load the view and pass the Salary Level details

        return view('admin.salarylevel.index')->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model = new SalaryLevelModel();
        $this->data['page_title'] = 'Add Salary Level'; //page title
        $this->data['model'] = $model;
        return view('admin.salarylevel.create')->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $SalaryLevelModel = new SalaryLevelModel;

        $validator = Validator::make($request->all(), [

            'salary_start' => 'required|max:30|alpha_num',
            'salary_end' => 'required|max:30|alpha_num',
            'eligibility' => 'required|numeric',
            'interest' => 'required|numeric',
            'interest_amount' => 'required',
            'total_to_be_repaid' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Storing Salary level details
            $SalaryLevelModel->salary_from = $request->input('salary_start');
            $SalaryLevelModel->salary_to = $request->input('salary_end');
            $SalaryLevelModel->eligibility = $request->input('eligibility');
            $SalaryLevelModel->interest = $request->input('interest');
            $SalaryLevelModel->interest_amount = $request->input('interest_amount');
            $SalaryLevelModel->total_to_be_repaid = $request->input('total_to_be_repaid');
            $SalaryLevelModel->status = $request->input('status');
            $SalaryLevelModel->created_at = date('Y-m-d H:i:s');

            if ($SalaryLevelModel->save()) {
                Session::flash('flash_message', 'Salary level added successfully!');
                return redirect('admin/salarylevels');
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
            return redirect(url('admin/salarylevels'));

        $model = SalaryLevelModel::find($id);
        $this->data['page_title'] = 'salary level - ' . $model->salary_from . ' to ' . $model->salary_to; //page title
        $this->data['model'] = $model;
        return view('admin.salarylevel.show')->with($this->data);
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
            return redirect(url('admin/salarylevels'));

        $model = SalaryLevelModel::find($id);
        $this->data['page_title'] = 'Edit salary level - ' . $model->salary_from . ' to ' . $model->salary_to; //page title
        $this->data['model'] = $model;
        return view('admin.salarylevel.edit')->with($this->data);
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
        $id = (int)$id;
        if ($id == '' || $id < 0)
            return redirect(url('admin/salarylevels'));

        $SalaryLevelModel = SalaryLevelModel::find($id);

        $validator = Validator::make($request->all(), [

            'salary_start' => 'required|max:30|alpha_num',
            'salary_end' => 'required|max:30|alpha_num',
            'eligibility' => 'required|numeric',
            'interest' => 'required|numeric',
            'interest_amount' => 'required',
            'total_to_be_repaid' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Storing Salary level details
            $SalaryLevelModel->salary_from = $request->input('salary_start');
            $SalaryLevelModel->salary_to = $request->input('salary_end');
            $SalaryLevelModel->eligibility = $request->input('eligibility');
            $SalaryLevelModel->interest = $request->input('interest');
            $SalaryLevelModel->interest_amount = $request->input('interest_amount');
            $SalaryLevelModel->total_to_be_repaid = $request->input('total_to_be_repaid');
            $SalaryLevelModel->status = $request->input('status');
            $SalaryLevelModel->created_at = date('Y-m-d H:i:s');

            if ($SalaryLevelModel->update()) {
                Session::flash('flash_message', 'Salary level updated successfully!');
                return redirect('admin/salarylevels');
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
        $SalaryLevelModel = SalaryLevelModel::find($id);
        $SalaryLevelModel->delete();

        // redirect
        Session::flash('flash_message', 'Salary level details deleted successfully!');
        return redirect('admin/salarylevels');
    }
}
