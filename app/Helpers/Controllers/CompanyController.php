<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\User;
use Mail;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->table = 'companies';
        $this->folder = 'company';
        view()->share('route', 'company');
        $this->limit = config('app.record_limit_web');
        $this->successCode = 200;
        $this->errorCode = 401;
        $this->warningCode = 500;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumb = array('title' => 'Company', 'action' => 'List Companies');
        $data = [];


        if ($request->has('status') && !empty($request->input('id'))) {
            $status = ($request->input('status') ? 0 : 1);
            DB::table('companies')->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
        }
        if ($request->has('type') && $request->input('type') == 'delete' && !empty($request->input('id'))) {
            DB::table($this->table)->where([['id', $request->input('id')]])->delete();
        }
        $companies = DB::table('companies');

        if (!empty($request->input('text'))) {
            $companies->where('name', 'like', '%' . $request->input('text') . '%');
        }
        if (!empty($request->input('orderby')) && !empty($request->input('order'))) {
            $companies->orderBy($request->input('orderby'), $request->input('order'));
        } else {
            $companies->orderBy('id', 'desc');
        }

        $data['companies'] = $companies->paginate($this->limit);
        $data['i'] = (($request->input('page', 1) - 1) * $this->limit);
        $data['orderby'] = $request->input('orderby');
        $data['order'] = $request->input('order');
        $data = array_merge($breadcrumb, $data);
        if ($request->ajax()) {
            return view('admin.company.index_element')->with($data);
        }
        return view('admin.company.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = array('title' => 'Company', 'action' => 'Add Company');

        $data = [];
        $data = array_merge($breadcrumb, $data);
        return view('admin.company.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            // 'image_tmp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            //'Company_name' => 'required|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/u|unique:companies',
            'name' => 'required',
            'user_name' => 'required',
            'email' => isset($request->email)?'email|unique:companies':'',
            'password' => 'required',
            // 'country_code' => 'required',
            // 'phone' => 'required',
            'country' => 'required',
            // 'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            // 'address' => 'required',
            'status' => 'required',
        ];
        $request->validate($rules);
        DB::beginTransaction();
        try {
            $data = ['name' => $request->name, 'email' => $request->email, 'password' => $request->password];
            if (isset($request->phone)) {
                $data['phone_number'] = $request->phone;
            }

            $request->request->add(['password' => Hash::make($request->input('password'))]);
            // print_r('yes'); die;
            $user  = Company::create($request->all());
            if (isset($request->image_tmp)) {
                //SAVE IMAGE
                $path = 'companies/' . $user->id . '/profile/';
                $imageName = 'company-image.' . $request->image_tmp->extension();
                $user['image'] = Storage::disk('public')->putFileAs(
                    'company/' . $user->id,
                    $request->image_tmp,
                    $imageName
                );
            }

            $user->save();


            // $m = Mail::send('admin.users.email', $data, function($message) use ($request) {
            //             $message->to($request->email, 'Login Credential')->subject('Login Credential');
            //         });
            // dd(DB::getQueryLog()); die;
            DB::commit();
            return back()->with('success', 'Company created!');
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $breadcrumb = array('title' => trans('admin.Company'), 'action' => trans('admin.Company Detail'));
        $data = [];
        $where = array('id' => $id);
        $record = Company::where($where)->first();

        if (empty($record)) {
            return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.Record not found!'));
        }

        if ($request->ajax()) {
            if ($request->has('type') && $request->input('type') == 'approve' && !empty($request->input('id'))) {
                $company = \App\Company::where(['id' => $id])->first();
                if (empty($company)) {
                    // return response()->json(['message'=>"can't approve until bargain not finished."], $this->warningCode);
                }
                $company->update(['verify' => 1]);
                return response()->json(['message' => trans('admin.Approved Succesfuly')], $this->successCode);
            }
        }

        $data['status'] = array(1 => 'Active', 0 => 'In-active');
        $data['record'] = $record;
        $data = array_merge($breadcrumb, $data);

        return view("admin.{$this->folder}.show")->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumb = array('title' => 'Company', 'action' => 'Edit Company');
        $data = [];
        $where = array('id' => $id);
        $record = Company::where($where)->first();
        if (empty($record)) {
            return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
        }

        $data['record'] = $record;
        $data = array_merge($breadcrumb, $data);
        return view("admin.{$this->folder}.edit")->with($data);
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
        $query = Company::where(['id' => $id]);
        $haveCompany = $query->first();
        $rules = [
            'email' => 'required|' . (!empty($haveCompany->id) ? 'unique:companies,email,' . $haveCompany->id : ''),
            'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
        if (!empty($request->reset_password)) {

            $rules['password'] = 'required|min:6';
        }
        $request->validate($rules);
        $input = $request->all();

        unset($input['_method'], $input['_token'], $input['image_tmp']);

        if ($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid()) {

            $imageName = 'company-image.' . $request->image_tmp->extension();
            if (!empty($haveCompany->image)) {
                Storage::disk('public')->delete($haveCompany->image);
            }

            $input['image'] = Storage::disk('public')->putFileAs(
                'Company/' . $haveCompany->id,
                $request->image_tmp,
                $imageName
            );
        }
        if (!empty($request->reset_password)) {
            $insert['password'] = Hash::make($request->input('password'));
        }
        if (isset($input['name'])) {
            $insert['name'] = $input['name'];
        }
        if (isset($input['email'])) {
            $insert['email'] = $input['email'];
        }
        if (isset($input['country_code'])) {
            $insert['country_code'] = $input['country_code'];
        }
        if (isset($input['phone'])) {
            $insert['phone'] = $input['phone'];
        }

        if (isset($input['image'])) {
            $insert['image'] = $input['image'];
        }
        if (isset($input['country'])) {
            $insert['country'] = $input['country'];
        }
        if (isset($input['state'])) {
            $insert['state'] = $input['state'];
        }
        if (isset($input['city'])) {
            $insert['city'] = $input['city'];
        }
        if (isset($input['zip'])) {
            $insert['zip'] = $input['zip'];
        }
        if (isset($input['address'])) {
            $insert['address'] = $input['address'];
        }
        Company::where('id', $id)->update($insert);

        return back()->with('success', __('Record updated!'));
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
    }
}
