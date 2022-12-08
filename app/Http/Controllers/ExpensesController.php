<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Expense;
use App\ExpenseAttachment;
use App\ExpenseType;
use App\User;

class ExpensesController extends Controller
{

    public function __construct()
    {
    }

    public function type_list()
    {
        $expense_types = ExpenseType::get();
        return view('admin.expenses.type_list')->with(['title' => 'Expense Type', 'action' => '', 'expense_types' => $expense_types]);
    }

    public function type_add(Request $request)
    {
        $expense_type = new ExpenseType;
        $expense_type->title = $request->title;
        $expense_type->save();
        return response()->json(['status' => 1, 'message' => 'Expense type added successfully']);
    }

    public function type_edit(Request $request)
    {
        $expense_type = ExpenseType::find($request->id);
        $expense_type->title = $request->title;
        $expense_type->save();
        return response()->json(['status' => 1, 'message' => 'Expense type updated successfully']);
    }

    public function type_delete(Request $request)
    {
        $expense_type = ExpenseType::find($request->id);
        $expense_type->delete();
        return response()->json(['status' => 1, 'message' => 'Expense type deleted successfully']);
    }

    public function list(Request $request)
    {
        // DB::enableQueryLog();

        $expenses = Expense::where('id','!=',null);
        $selected_driver = "";
        $selected_expense_type = "";
        $selected_from_date = "";
        $selected_to_date = "";
        if(!empty($request->driver)){
            $selected_driver = $request->driver;
            $expenses = $expenses->where(['driver_id' => $request->driver]);
        }
        if(!empty($request->expense_type)){
            $selected_expense_type = $request->expense_type;
            $expenses = $expenses->where(['type' => $request->expense_type]);
        }
        if(!empty($request->start_date) && !empty($request->end_date)){
            $selected_from_date = $request->start_date;
            $selected_to_date = $request->end_date;
            // $expenses->where(function ($query) use ($selected_from_date, $selected_to_date) {
               
            // });
            $expenses->whereRaw("date(created_at) between date('".date('Y-m-d',strtotime($selected_from_date))."') and date('".date('Y-m-d',strtotime($selected_to_date))."')");
        }
        $expenses = $expenses->orderBy('created_at','desc')->paginate(20);
        // dd(DB::getQueryLog());

        $drivers = User::select('id', 'first_name', 'last_name', 'phone')->where(['user_type' => 2])->orderBy('first_name')->get();
        $expense_types = Expense::select('type')->groupBy('type')->orderBy('type')->get();
        return view('admin.expenses.list')->with(['selected_from_date'=>$selected_from_date,'selected_to_date'=>$selected_to_date,'title' => 'Expenses', 'action' => '', 'expenses' => $expenses, 'drivers' => $drivers, 'expense_types' => $expense_types, 'selected_driver' => $selected_driver, 'selected_expense_type' => $selected_expense_type]);
    }

    public function show(Request $request, $id){
        $expense_detail = Expense::find($id);
        return view('admin.expenses.show')->with(['title' => 'Expense Detail', 'action' => '', 'expense_detail' => $expense_detail]);
    }

}
