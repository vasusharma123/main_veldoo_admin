<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Expense;
use App\ExpenseAttachment;
use App\ExpenseType;
use App\Ride;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{

    public function __construct(Request $request = null)
    {
        $this->successCode = 200;
        $this->errorCode = 401;
        $this->warningCode = 500;
    }

    public function types()
    {
        $types = ExpenseType::get();
        return response()->json(['message' => 'Type of expenses', 'data' => $types], $this->successCode);
    }

    public function add(Request $request)
    {
        $rules = [
            'type' => 'required|max:100',
            'amount' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' =>  $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
        }
        $userDetail = Auth::user();
        DB::beginTransaction();
        try {
            $createExpense = Expense::create(['driver_id' => $userDetail->id, 'type' => $request->type, 'ride_id' => $request->ride_id ?? '', 'amount' => $request->amount, 'note' => $request->note ?? '']);
            if (!empty($request->attachments)) {
                foreach ($request->attachments as $file_key => $file) {
                    $fileName = Storage::disk('public')->putFileAs(
                        'expenses',
                        $request->file('attachments')[$file_key],
                        'expense' . rand(0, 10) . time() . rand(0, 10) . $file->extension()
                    );

                    $attachmentObj = new ExpenseAttachment;
                    $attachmentObj->expense_id = $createExpense->id;
                    $attachmentObj->url = $fileName;
                    $attachmentObj->save();
                }
            }
            DB::commit();
            return response()->json(['status' => 1, 'message' => 'Expense added successfully'], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()], $this->warningCode);
        }
    }

    public function list()
    {
        $userDetail = Auth::user();
        $expense_list = Expense::with(['attachments', 'ride:id,ride_time,status'])->where(['driver_id' => $userDetail->id])->orderBy('id', 'desc')->paginate(20);
        return response()->json(['status' => 1, 'message' => 'List of my expenses', 'data' => $expense_list], $this->successCode);
    }

    public function my_rides()
    {
        $userDetail = Auth::user();
        $my_rides = Ride::select('id', 'ride_time', 'status')->where(['driver_id' => $userDetail->id])->get();
        return response()->json(['status' => 1, 'message' => 'My rides List', 'data' => $my_rides], $this->successCode);
    }

}
