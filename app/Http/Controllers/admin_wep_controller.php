<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\employe;
use App\Models\client;
use App\Models\bill;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Storage;



class admin_wep_controller extends Controller
{


    public function providers()
{
    $providers = Provider::all();
    return view('admin.data.data_provider', compact('providers'));
}

public function provider_detailes($id)
{
    $provider = Provider::findOrFail($id);
    return view('admin.detailes_provider', compact('provider'));
}

public function edit_provider($id)
{
    $provider = Provider::findOrFail($id);
    return view('admin.edit_detailes_provider', compact('provider'));
}
public function add_provider(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:providers',
        'password' => 'required|string|min:6',
        'area' => 'nullable|string|max:255',
        'streets' => 'nullable|string|max:255',
        'feez' => 'nullable|integer',
        'phone' => 'nullable|numeric',
        'phone2' => 'nullable|numeric',
        'photo' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
        'cost_pk' => 'required|integer',
        'license' => 'required|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:20000',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }


    $data = $validator->validated();

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo')->store('comp_photos', 'public');
    }

    if ($request->hasFile('license')) {
        $license = $request->file('license')->store('comp_licenses', 'public');
    }

    $provider = Provider::create(array_merge(
        $validator->validated(),
        $request->photo ? ['photo' => $photo] : [],
        [
            'password' => Hash::make($request->password),
            'license'=> $license,
        ]
    ));
    return redirect()->route('data-provider')->with('success', 'Provider updated successfully');
}


// public function update_provider(Request $request,$id)
// {
//     $validator = Validator::make($request->all(), [
//         'id'=>'required',
//         'name' => 'sometimes|required|string|max:255',
//         'email' => 'sometimes|required|string|email|max:255|unique:providers,email,' . $request->id,
//         'password' => 'sometimes|required|string|min:6',
//         'area' => 'sometimes|nullable|string|max:255',
//         'streets' => 'sometimes|nullable|string|max:255',
//         'feez' => 'sometimes|nullable|integer',
//         'phone' => 'sometimes|nullable|integer',
//         'phone2' => 'sometimes|nullable|integer',
//         'photo' => 'sometimes|nullable|mimes:jpeg,jpg,png,gif|max:10000',
//         'cost_pk' => 'sometimes|required|integer',
//         'license' => 'sometimes|required|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:20000',
//     ]);

//     if ($validator->fails()) {
//         return redirect()->back()->withErrors($validator)->withInput();
//     }

//     $provider = Provider::find($request->id);
//     if (!$provider) {
//         return redirect()->back()->with('error', 'Provider not found');
//     }

//     if ($request->hasFile('photo')) {
//         if ($provider->photo) {
//             Storage::disk('public')->delete($provider->photo);
//         }
//         $photo = $request->file('photo')->store('comp_photos', 'public');
//         $provider->photo = $photo;
//     }

//     if ($request->hasFile('license')) {
//         if ($provider->license) {
//             Storage::disk('public')->delete($provider->license);
//         }
//         $license = $request->file('license')->store('comp_licenses', 'public');
//         $provider->license = $license;
//     }

//     $provider->update(array_merge(
//         $validator->validated(),
//         $request->password ? ['password' => Hash::make($request->password)] : [],
//         [
//             'photo' => $provider->photo,
//             'license' =>$provider->license,
//         ]
//     ));

//     return redirect()->route('admin.providers')->with('success', 'Provider updated successfully');
// }


public function update_provider(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|string|email|max:255|unique:providers,email,' . $id,
        'password' => 'sometimes|nullable|string|min:6',
        'area' => 'sometimes|nullable|string|max:255',
        'streets' => 'sometimes|nullable|string|max:255',
        'feez' => 'sometimes|nullable|integer',
        'phone' => 'sometimes|nullable|string|max:15',
        'phone2' => 'sometimes|nullable|string|max:15',
        'photo' => 'sometimes|nullable|mimes:jpeg,jpg,png,gif|max:10000',
        'cost_pk' => 'sometimes|required|integer',
        'license' => 'sometimes|nullable|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:20000',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $provider = Provider::find($id);
    if (!$provider) {
        return redirect()->back()->with('error', 'Provider not found');
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
            'license' => $provider->license,
        ]
    ));

    return redirect()->route('data-provider')->with('success', 'Provider updated successfully');
}

public function delete_provider(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required',
    ]);

    $provider = Provider::find($request->id);
    if (!$provider) {
        return redirect()->back()->with('error', 'Provider not found');
    }

    if ($provider->photo) {
        Storage::disk('public')->delete($provider->photo);
    }
    if ($provider->license) {
        Storage::disk('public')->delete($provider->license);
    }

    $provider->delete();
    return redirect()->route('admin.providers')->with('success', 'Provider deleted successfully');
}


public function employes($providerId)
{
    // استرجاع الموظفين بناءً على مزود معين
    $employees = Employe::where('provider_id', $providerId)->get();

    // استرجاع اسم المزود لأغراض العرض (يمكنك استبداله بما يناسب حالتك)
    $providerName = Provider::find($providerId)->name;

    return view('admin.data.data_employees', [
        'employees' => $employees,
        'providerName' => $providerName
    ]);
}
public function clients($providerId)
{
    // استرجاع الموظفين بناءً على مزود معين
    $clients = client::where('provider_id', $providerId)->get();

    // استرجاع اسم المزود لأغراض العرض (يمكنك استبداله بما يناسب حالتك)
    $providerName = Provider::find($providerId)->name;

    return view('admin.data.data_subscriber', [
        'clients' => $clients,
        'providerName' => $providerName
    ]);
}


public function paid_bill($providerId)
    {

       $bills =  Bill::where('provider_id', $providerId)->where('state', 1)->with(['user.clients'])
       ->orderBy('created_at', 'desc')
       ->get();

       $count = $bills->count();
       $amount = $bills->sum('cost');


       return view('admin.invioces_paid', [
        'count' => $count,
        'amount' => $amount,
        'bills' => $bills,
        'providerId' =>$providerId

    ]);
    }

    public function not_paid_bill($providerId)
    {

       $bills =  Bill::where('provider_id', $providerId)->where('state', 0)->with(['user.clients'])
       ->orderBy('created_at', 'desc')
       ->get();

       $count = $bills->count();
       $amount = $bills->sum('cost');


       return view('admin.invioces_not_paid', [
        'count' => $count,
        'amount' => $amount,
        'bills' => $bills,
        'providerId' =>$providerId

    ]);


    }

    public function dash()
    {

       $providers =  provider::all();
       $clients =  client::all();
       $employes =  employe::all();




       return view('admin.dashboard', [
        'providers' => $providers->count(),
        'clients' => $clients->count(),
        'employes' => $employes->count(),

    ]);


    }


}
