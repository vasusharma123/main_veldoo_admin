<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Expense;
use App\ExpenseAttachment;
use App\ExpenseType;

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

    public function list()
    {
        $expenses = Expense::paginate(20);
        return view('admin.expenses.list')->with(['title' => 'Expenses', 'action' => '', 'expenses' => $expenses]);
    }

}
