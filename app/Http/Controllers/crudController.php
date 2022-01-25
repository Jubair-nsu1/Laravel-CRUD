<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\crudModel;
use Session;

class crudController extends Controller
{
    public function showData(){
        
        //$show = crudModel::all();
        $show = crudModel::paginate(4);
        return view('show_data', compact('show'));
    }

    public function addData(){
        return view('add_data');
    }


    //Adding data to the database
    public function storeData(Request $request){
        //Validation 
        $rules = [
            'name' => 'required|max:10',
            'email' => 'required|email'
        ];
        $cm = [
            'name.required' => 'Enter your name',
            'name.max' => 'Your name cannot contain more than 10 characters',
            'email.required' => 'Enter your email',
            'email.email' => 'Email must be a valid email'
        ];

        $this->validate($request, $rules, $cm);

        //Create an object of the model
        $crud = new crudModel();

        //$crud->[Database field name] = $request->[form field name];
        $crud->name = $request->name;
        $crud->email = $request->email;
        $crud->save();

        Session::flash('msg','Data successfully Added');

        //return $request->all();
        return redirect('/');
        
    }

    public function editData($id=null){
        $edit = crudModel::find($id);
        return view('edit_data', compact('edit'));
    }


    //Updating data to the database
    public function updateData(Request $request, $id){
        //Validation 
        $rules = [
            'name' => 'required|max:10',
            'email' => 'required|email'
        ];
        $cm = [
            'name.required' => 'Enter your name',
            'name.max' => 'Your name cannot contain more than 10 characters',
            'email.required' => 'Enter your email',
            'email.email' => 'Email must be a valid email'
        ];

        $this->validate($request, $rules, $cm);

        //Create an object of the model
        $crud = crudModel::find($id);

        //$crud->[Database field name] = $request->[form field name];
        $crud->name = $request->name;
        $crud->email = $request->email;
        $crud->save();

        Session::flash('msg','Data successfully Updated');

        //return $request->all();
        return redirect('/');
        
    }


    public function deleteData($id=null){
        $delete = crudModel::find($id);

        $delete->delete();
        Session::flash('msg','Data successfully Deleted');
        return redirect('/');
    }

}
