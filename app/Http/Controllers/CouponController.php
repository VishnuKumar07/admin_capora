<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::latest()->get();
        return view('coupons.index',compact('coupons'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percentage,flat',
            'value' => 'required|numeric|min:1',
            'expiry_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Coupon::create([
            'code'                 => $request->code,
            'type'                 => $request->type,
            'value'                => $request->value,
            'expiry_date'          => $request->expiry_date,
            'status'               => $request->status,
            'usage_limit_type'     => $request->usage_limit_type,
            'user_limit'           => $request->usage_limit_type == 'limited' ? $request->user_limit : null,
            'per_user_limit_type'  => $request->per_user_limit_type,
            'per_user_limit'       => $request->per_user_limit_type == 'limited' ? $request->per_user_limit : null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Coupon created successfully'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:coupons,id',
            'status' => 'required|in:active,inactive'
        ]);

        $coupon = Coupon::find($request->id);

        if ($coupon->status == 'expired') {
            return response()->json([
                'status' => false,
                'message' => 'Expired coupons cannot be modified'
            ], 403);
        }

        $coupon->status = $request->status;
        $coupon->save();

        return response()->json([
            'status' => true,
            'message' => 'Coupon status updated successfully'
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:coupons,id',
            'code' => 'required|string|max:50|unique:coupons,code,' . $request->id,
            'type' => 'required|in:percentage,flat',
            'value' => 'required|numeric|min:1',
            'expiry_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $coupon = Coupon::find($request->id);

        $coupon->update([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'expiry_date' => $request->expiry_date,
            'status' => $request->status,
            'usage_limit_type' => $request->usage_limit_type,
            'user_limit' => $request->usage_limit_type == 'limited' ? $request->user_limit : null,
            'per_user_limit_type' => $request->per_user_limit_type,
            'per_user_limit' => $request->per_user_limit_type == 'limited' ? $request->per_user_limit : null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Coupon updated successfully'
        ]);
    }



    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon not found'
            ], 404);
        }

        $coupon->delete();

        return response()->json([
            'status' => true,
            'message' => 'Coupon deleted successfully'
        ]);
    }

}
