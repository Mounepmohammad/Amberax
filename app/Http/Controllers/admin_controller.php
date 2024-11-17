<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Storage;


class admin_controller extends Controller
{


     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin_auth:admin-api');
    }
    // عرض جميع المزودين
    public function providers()
    {
        $providers = Provider::all();
        return response()->json(['providers' => $providers], 200);
    }

    // إضافة مزود جديد
    public function add_provider(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:providers',
        'password' => 'required|string|min:6',
        'area' => 'nullable|string|max:255',
        'streets' => 'nullable|string|max:255',
        'feez' => 'nullable|integer',
        'phone' => 'nullable|integer',
        'phone2' => 'nullable|integer',
        'photo' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
        'cost_pk' => 'required|integer',
        'license' => 'required|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:20000',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $data = $validator->validated();

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo')->store('comp_photos', 'public');
    }

    if ($request->hasFile('license')) {
        $license = $request->file('license')->store('comp_licenses', 'public');
    }

    $provider = provider::create(array_merge(
        $validator->validated(),
        $request->photo ? ['photo' => $photo] : [],
        [
            'password' => Hash::make($request->password),
            'license'=> $license,
        ]
    ));
    return response()->json(['message' => 'Provider added successfully', 'provider' => $provider], 201);
}

    // تعديل مزود موجود
    public function update_provider(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:providers,email,' . $request->id,
            'password' => 'sometimes|required|string|min:6',
            'area' => 'sometimes|nullable|string|max:255',
            'streets' => 'sometimes|nullable|string|max:255',
            'feez' => 'sometimes|nullable|integer',
            'phone' => 'sometimes|nullable|integer',
            'phone2' => 'sometimes|nullable|integer',
            'photo' => 'sometimes|nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'cost_pk' => 'sometimes|required|integer',
            'license' => 'sometimes|required|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:20000',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $provider = Provider::find($request->id);
        if (!$provider) {
            return response()->json(['message' => 'Provider not found'], 404);
        }
        if ($request->hasFile('photo')) {
            if ($provider->photo) {
                Storage::disk('public')->delete($provider->photo);
            }
            $photo = $request->file('photo')->store('comp_photos', 'public');
            $provider->photo = $photo;
        }

        if ($request->hasFile('license')) {
            if ($provider->license) {
                Storage::disk('public')->delete($provider->license);
            }
            $license = $request->file('license')->store('comp_licenses', 'public');
            $provider->license = $license;
        }
        $provider->update(array_merge(
            $validator->validated(),
            $request->password ? ['password' => Hash::make($request->password)] : [],
            [
            'photo' => $provider->photo,
            'license' =>$provider->license,

            ]
        ));

        return response()->json(['message' => 'Provider updated successfully', 'provider' => $provider], 200);
    }

    // حذف مزود
    public function delete_provider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        $provider = Provider::find($request->id);
        if (!$provider) {
            return response()->json(['message' => 'Provider not found'], 404);
        }

        if ($provider->photo) {
            Storage::disk('public')->delete($provider->photo);
        }
        if ($provider->license) {
            Storage::disk('public')->delete($provider->license);
        }


        $provider->delete();
        return response()->json(['message' => 'Provider deleted successfully'], 200);
    }
}

