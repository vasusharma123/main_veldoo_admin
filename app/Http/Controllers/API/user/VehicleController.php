<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Price;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;

    public function __construct(Request $request = null)
    {
    }

    /* Vehicle Types based on Default Service Provider */

    public function vehicleTypes(Request $request)
    {
        $user = Auth::user();
        try {
            $vehicleTypes = [];
            if($user->service_provider_id){
                $vehicleTypes = Price::where(['service_provider_id' => $user->service_provider_id])->orderBy('sort')->get();
            }
            return response()->json(['message' => __('List of vehicle types'), 'data' => $vehicleTypes], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    /* Vehicle Types based on Service Provider ID */

    public function sp_based_vehicle_types(Request $request)
    {
        try {
            $vehicleTypes = [];
            if ($request->service_provider_id) {
                $vehicleTypes = Price::where(['service_provider_id' => $request->service_provider_id])->orderBy('sort')->get();
            }
            return response()->json(['message' => __('List of vehicle types'), 'data' => $vehicleTypes], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

}
