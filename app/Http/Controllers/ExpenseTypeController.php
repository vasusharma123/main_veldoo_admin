<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exports\RideExport;
use App\PaymentMethod;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Hash;
use Storage;
use App\Price;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\ExpenseType;
use App\Expense;

class ExpenseTypeController extends Controller
{

    public function index(Request $request)
    {
        $obj = new UserController();
        $sp_id = $obj->getSpId();
        //dd(\Request::route()->getName());
        $data = array('page_title' => 'Managers', 'action' => 'Managers','page' => 'manager','uri' => 'manager');
        $expenseData =  ExpenseType::where('service_provider_id',$sp_id)->orderBy('title','asc');
        $data['expensis'] = $expenseData->get();
        $data['expenseData'] = Expense::with('driver')->where('service_provider_id',$sp_id)->where('type','expense')->orderBy('id','desc')->get();
        $data['expensisArray'] = $expenseData->pluck('title');
        return view("admin.expensis.index")->with($data);
      
    }

    public function store(Request $request)
    {
        Log::info('In manager store');
        $request->validate([
            'expenseType' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $obj = new UserController();
            $sp_id = $obj->getSpId();
            $expenseType =  new ExpenseType();
            $expenseType->title = $request->expenseType;
            $expenseType->service_provider_id = $sp_id;
            $saved  = $expenseType->save();
            if($saved){
                 DB::commit();

                return redirect()->route('expense-type.index')->with('success','Expense Type successfully created');
            }
        } catch (Exception $e) {
            Log::info('exception'.$e);
        }
    }
    public function fetchExpense(Request $request)
    {
        DB::beginTransaction();
        try
        {   
            $obj = new UserController();
            $sp_id = $obj->getSpId();
            $data =  ExpenseType::where('id',Crypt::decrypt($request->id))->where('service_provider_id', $sp_id)->first();
			   if($data){
					$arr = [];
					$arr['expenseType'] = $data->title;
                    $arr['id'] = $data->id;
				}
               return response()->json($arr);

        } catch (Exception $e) {
            Log::info('exception'.$e);
        }

    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'expenseType' => 'required',
        ]);
        
        $updated = ExpenseType::where('id',$id)->update(['title' => $request->expenseType]);
        if($updated){
            return redirect()->route('expense-type.index')->with('success','Expense Type successfully updated');
        }
    }


    public function destroy(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            $obj = new UserController();
            $sp_id = $obj->getSpId();
            ExpenseType::where(['id'=>$id,'service_provider_id' => $sp_id])->delete();
            DB::commit();
            
            return redirect()->route('expense-type.index')->with('success','Expense type has been deleted');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function fetchExpenseData(Request $request)
    {
        DB::beginTransaction();
        try
        {   
            $obj = new UserController();
            $sp_id = $obj->getSpId();
            $data =  Expense::where('id',Crypt::decrypt($request->id))->where('service_provider_id', $sp_id)->first();
			   if($data){
					$arr = [];
					$arr['amount'] = $data->amount;
                    $arr['type_detail'] = $data->type_detail;
                    $arr['note'] = $data->note;
                    $arr['id'] = $data->id;
				}
               return response()->json($arr);

        } catch (Exception $e) {
            Log::info('exception'.$e);
        }

    }
    
}