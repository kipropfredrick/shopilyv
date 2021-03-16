<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect,Response;
class CustomerController extends Controller
{
    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/

	public function index()
	{
		$customers = User::latest()->paginate(4);
		return view('customers.index',compact('customers'))->with('i', (request()->input('page', 1) - 1) * 4);
	}
	public function display(){
		$userdetails= User::all();
		return $userdetails;
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/

	public function create()
	{
		return view('customers.create');
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param \Illuminate\Http\Request $request
	* @return \Illuminate\Http\Response
	*/

	public function store(Request $request)
	{

		$r=$request->validate([
		'name' => 'required',
		'email' => 'required',
		
		]);

		$custId = $request->cust_id;
		User::updateOrCreate(['id' => $custId],['name' => $request->name, 'email' => $request->email]);
		if(empty($request->cust_id))
			$msg = 'Customer entry created successfully.';
		else
			$msg = 'Customer data is updated successfully';
		return redirect()->route('customers.index')->with('success',$msg);
	}

	/**
	* Display the specified resource.
	*
	* @param int $id
	* @return \Illuminate\Http\Response
	*/

	public function show(User $customer)
	{
		return view('customers.show',compact('customer'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param int $id
	* @return \Illuminate\Http\Response
	*/
	
	public function edit($id)
	{
		$where = array('id' => $id);
		$customer = User::where($where)->first();
		return Response::json($customer);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param \Illuminate\Http\Request $request
	* @param int $id
	* @return \Illuminate\Http\Response
	*/

	public function update(Request $request)
	{

	}

	/**
	* Remove the specified resource from storage.
	*
	* @param int $id
	* @return \Illuminate\Http\Response
	*/

	public function destroy($id)
	{
		$cust = Customer::where('id',$id)->delete();
		return Response::json($cust);
	}
	public function delete($id)
    {
        $project = Project::find($id);

        return view('projects.delete', compact('project'));
    }
}
