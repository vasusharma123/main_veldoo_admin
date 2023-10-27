<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exports\RideExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use Storage;
use App\Price;
use Illuminate\Validation\Rule;


class ManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd(\Request::route()->getName());
        $data = array('page_title' => 'Managers', 'action' => 'Managers');
        $company = Auth::user();
        $data['managers'] = User::where(['user_type'=>5,'company_id'=>Auth::user()->company_id])->orderBy('first_name', 'ASC')->paginate(20);
        $data['users'] = User::where(['user_type' => 1, 'company_id' => Auth::user()->company_id])->orderBy('first_name', 'ASC')->get();

        $data['vehicle_types'] = Price::orderBy('sort')->get();

        return view('company.managers.index')->with($data);
    }

    public function create(Request $request)
	{
		$breadcrumb = array('page_title' => 'Create Manager', 'action' => 'Create Manager');
		$data = [];
		$data = array_merge($breadcrumb, $data);
		return view("company.managers.create")->with($data);
	}

    public function store(Request $request)
    {

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:191',Rule::unique('users')->where(function ($query) use ($request) {
                return $query->where('user_type', 5)->whereNull('deleted_at');
            })],
            'name' => 'required',
            'password' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $data = ['first_name'=>$request->name, 'name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->password),'user_type'=>5,'company_id'=>Auth::user()->company_id];
            $data['created_by'] = Auth::user()->id;
            if ($request->phone)
            {
                $data['phone'] = str_replace(' ', '', $request->phone);
                $data['country_code'] = $request->country_code;
            }
            $manager = new User();
            $manager->fill($data);
            $manager->save();

            if ($request->image) {
				$imageName = 'profile-image'.time().'.' . $request->image->extension();
				$image = Storage::disk('public')->putFileAs(
					'manager/' . $manager->id,
					$request->image,
					$imageName
				);
				User::where('id', $manager->id)->update(['image' => $image]);
			}
            DB::commit();
            return redirect()->route('managers.index')->with('success','Manager successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            User::where(['user_type'=>5,'company_id'=>Auth::user()->company_id,'id'=>$id])->delete();
            DB::commit();
            return redirect()->route('managers.index')->with('success','Manager has been deleted');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function edit(Request $request,$id)
	{
		$data = array('page_title' => 'Edit Manager', 'action' => 'Edit Manager');
		$data['manager'] = User::where(['user_type'=>5,'company_id'=>Auth::user()->company_id])->find($id);
		return view("company.managers.edit")->with($data);
	}

    public function update(Request $request,$id)
    {
        // dd($id);
        $request->validate([
           // 'email' => 'email|required|unique:users,email,'.$id,
            'email' => ['required', 'string', 'email', 'max:191',Rule::unique('users')->where(function ($query) use ($id) {
                return $query->where('user_type', 5)->whereNotNull('deleted_at')->where('id', $id);
            })],
            'name' => 'required',
            // 'password' => 'required',
        ]);


       

        DB::beginTransaction();
        try
        {

            $existEmail = User::where(['user_type'=>5,'company_id'=>Auth::user()->company_id])->whereNull('deleted_at')
            ->where('id', '!=', $id)->where('email', $request->email)->first();

            if($existEmail){
                return redirect()->back()->with('error','This email has already been taken')->withInput($request->all());
            }

            $data = ['first_name'=>$request->name, 'name'=>$request->name,'email'=>$request->email];
            if ($request->phone)
            {
                $data['phone'] = str_replace(' ', '', $request->phone);
                $data['country_code'] = $request->country_code;
            }
            if ($request->password)
            {
                $data['password'] = Hash::make($request->password);
            }
            if ($request->image) {
				$imageName = 'profile-image'.time().'.' . $request->image->extension();
				$image = Storage::disk('public')->putFileAs(
					'manager/' . $id,
					$request->image,
					$imageName
				);
				User::where('id', $id)->update(['image' => $image]);
			}
            // dd($data);
            $manager = User::where(['user_type'=>5,'company_id'=>Auth::user()->company_id])->find($id);
            $manager->fill($data);
            $manager->update();
            DB::commit();
            return redirect()->route('managers.index')->with('success','Manager information successfully updated.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
