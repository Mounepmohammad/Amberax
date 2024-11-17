<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\employe;
use App\Models\user_req;
use App\Models\client;
use App\Models\complaint;
use App\Models\offer;
use App\Models\bill;
use App\Models\complaint_response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;

class provider_controller extends Controller
{
 /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('provider_auth:provider-api');
        $this->updateOffers();
    }




    public function complete_profile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'area' => 'sometimes|nullable|string|max:255',
            'streets' => 'sometimes|nullable|string|max:255',
            'feez' => 'sometimes|nullable|integer',
            'cost_pk' => 'sometimes|required|integer',
            'phone' => 'sometimes|nullable|numeric',
            'phone2' => 'sometimes|nullable|numeric',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $provider = Provider::find($request->id);
        if (!$provider) {
            return response()->json(['message' => 'Provider not found'], 404);
        }
        if ($request->hasFile('photo')) {
            // Delete the old id photo file
            if($provider->photo){
            Storage::disk('public')->delete($provider->photo);
            }
            // Handle new file upload
            $photo = $request->file('photo')->store('comp_photos', 'public');
            $provider->photo = $photo;
        }
        $provider->update(array_merge(
            $validator->validated(),[
                'photo'=> $provider->photo,
                ]
        ));

        return response()->json(['message' => 'Provider updated successfully', 'provider' => $provider], 200);
    }





    public function employes(Request $request)
    {
        $employes = auth('provider-api')->user()->employes()->get();
        return response()->json(['employes' => $employes], 200);
    }

    // إضافة موظف جديد
    public function add_collector(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employes',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('employe_photos', 'public');
        }

        $employe = employe::create(array_merge(
            $validator->validated(),
            $request->photo ? ['photo' => $photo] : [],
            [
                'provider_id'=>auth('provider-api')->user()->id ,
                'password' => bcrypt($request->password),
                'type'=> 1,

            ]
        ));

        return response()->json(['message' => 'Employe created successfully', 'employe' => $employe], 200);
    }



     // إضافة موظف جديد
     public function add_accountent(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:employes',
             'password' => 'required|string|min:6',
             'address' => 'nullable|string|max:500',
             'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
         ]);

         if ($validator->fails()) {
             return response()->json($validator->errors(), 422);
         }

         if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('employe_photos', 'public');
        }

         $employe = employe::create(array_merge(
             $validator->validated(),
             $request->photo ? ['photo' => $photo] : [],
             [
                 'provider_id'=>auth('provider-api')->user()->id ,
                 'password' => bcrypt($request->password),
                 'type'=> 2,

             ]
         ));

         return response()->json(['message' => 'Employe created successfully', 'employe' => $employe], 200);
     }

     public function add_maintenance(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:employes',
             'password' => 'required|string|min:6',
             'address' => 'nullable|string|max:500',
             'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
         ]);

         if ($validator->fails()) {
             return response()->json($validator->errors(), 422);
         }

         if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('employe_photos', 'public');
        }

         $employe = employe::create(array_merge(
             $validator->validated(),
             $request->photo ? ['photo' => $photo] : [],
             [
                 'provider_id'=>auth('provider-api')->user()->id ,
                 'password' => bcrypt($request->password),
                 'type'=> 3,

             ]
         ));

         return response()->json(['message' => 'Employe created successfully', 'employe' => $employe], 200);
     }


    // تعديل موظف موجود
    public function update_employe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:employes,id',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:employes,email,' . $request->id,
            'password' => 'sometimes|required|string|min:6',
            'address' => 'sometimes|nullable|string|max:500',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employe = Employe::find($request->id);
        if (!$employe) {
            return response()->json(['message' => 'Employe not found'], 404);
        }
        if ($request->hasFile('photo')) {
            if ($employe->photo) {
                Storage::disk('public')->delete($employe->photo);
            }
            $photo = $request->file('photo')->store('employe_photos', 'public');
            $employe->photo = $photo;
        }

        $employe->update(array_merge(
            $validator->validated(),
            $request->password ? ['password' => bcrypt($request->password)] : [] ,
            [
            'photo'=> $employe->photo,
            ]

        ));

        return response()->json(['message' => 'Employe updated successfully', 'employe' => $employe], 200);
    }

    // حذف موظف
    public function delete_employe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:employes,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employe = Employe::find($request->id);
        if (!$employe) {
            return response()->json(['message' => 'Employe not found'], 404);
        }
        if ($employe->photo) {
            Storage::disk('public')->delete($employe->photo);
        }


        $employe->delete();
        return response()->json(['message' => 'Employe deleted successfully'], 200);
    }



    public function users_request(Request $request)
    {
        $requests = auth('provider-api')->user()->requests()->with('user')->get();
        return response()->json(['requests' => $requests], 200);
    }



    public function complete_request(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|integer|exists:user_reqs,id',
        'client_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
       // 'counter' => 'required|integer|unique:clients,counter',
        'phone' => 'required|numeric|digits:10',
        'id_photo' => 'required|image|mimes:jpeg,jpg,png,gif|max:10000', // Ensure this is a file input
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $user_req = user_req::find($request->id);
    if (!$user_req) {
        return response()->json(['message' => 'request not found'], 404);
    }

    // Handle file upload
    $idPhotoPath = $request->file('id_photo')->store('id_photos', 'public');
    $idPhotoUrl = asset('storage/' . $idPhotoPath);

    $client = Client::create(array_merge(
        $validator->validated(),
        ['id_photo' => $idPhotoPath,
        'user_id'=>$user_req->user_id,
        'provider_id'=>$user_req->provider_id,
        'counter'=>0,
        'box_number'=>0,
        ]
    ));

    $user_req->delete();


    return response()->json(['message' => 'Client added successfully', 'client' => $client,'id_photo_url' => $idPhotoUrl], 200);
}



public function clients(Request $request)
{
    $clients = auth('provider-api')->user()->clients()->get();
    return response()->json(['clients' => $clients], 200);
}



public function update_client(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|integer|exists:clients,id',
        'client_name' => 'sometimes|required|string|max:255',
        'address' => 'sometimes|required|string|max:255',
        //'counter' => 'sometimes|required|integer|unique:clients,counter,' . $request->id,
        'phone' => 'sometimes|required|numeric|digits:10',
        'id_photo' => 'sometimes|required|image|mimes:jpeg,jpg,png,gif|max:10000', // Ensure this is a file input
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $client = Client::find($request->id);
    if (!$client) {
        return response()->json(['message' => 'Client not found'], 404);
    }

    if ($request->hasFile('id_photo')) {
        // Delete the old id photo file
        Storage::disk('public')->delete($client->id_photo);

        // Handle new file upload
        $idPhotoPath = $request->file('id_photo')->store('id_photos', 'public');
        $client->id_photo = $idPhotoPath;
    }

    $client->update(array_merge(
        $validator->validated(),
        ['id_photo' => $client->id_photo]
    ));

    return response()->json(['message' => 'Client updated successfully', 'client' => $client], 200);
}


public function delete_client(Request $request)
{
    $client = Client::find($request->id);

    if (!$client) {
        return response()->json(['message' => 'Client not found'], 404);
    }

    // Delete the id photo file
    Storage::disk('public')->delete($client->id_photo);

    $client->delete();

    return response()->json(['message' => 'Client deleted successfully'], 200);
}

public function complaints(Request $request)
{
    $complaints = auth('provider-api')->user()->complaints()->with('responses')->get();
    return response()->json(['complaints' => $complaints], 200);
}

public function add_response(Request $request)
{
    // التحقق من صحة البيانات المدخلة
    $validator = Validator::make($request->all(), [
        'complaint_id' => 'required|integer|exists:complaints,id',
        'comp_response' => 'required|string|max:1000',
    ]);

    // إرجاع الأخطاء في حالة وجودها
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // العثور على الشكوى
    $complaint = Complaint::find($request->complaint_id);
    if (!$complaint) {
        return response()->json(['message' => 'Complaint not found'], 404);
    }

    // إنشاء الرد الجديد
    $response = complaint_response::create(array_merge(
        $validator->validated(),
    ));

    return response()->json(['message' => 'Response added successfully', 'response' => $response], 200);
}

public function delete_complaint(Request $request)
{
    $complaint = complaint::find($request->id);

    if (!$complaint) {
        return response()->json(['message' => 'Complaint not found'], 404);
    }

    $complaint->delete();

    return response()->json(['message' => 'Complaint deleted successfully'], 200);
}

public function offers(Request $request)
{
    $offer = auth('provider-api')->user()->offers()->get();
    return response()->json(['offer' => $offer], 200);
}


public function add_offer(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'cost_pk' => 'required|integer',
        'days' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $offer = offer::create(array_merge(
        $validator->validated(),
        ['provider_id'=>auth('provider-api')->user()->id]
    ));

    return response()->json(['message' => 'offer added successfully', 'offer' => $offer], 200);
}



public function update_offer(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:offers,id',
        'title' => 'sometimes|required|string',
        'cost_pk' => 'sometimes|required|integer',
        'days' => 'sometimes|required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $offer = offer::find($request->id);
    if (!$offer) {
        return response()->json(['message' => 'offer not found'], 404);
    }

    $offer->update(array_merge($validator->validated()));

    return response()->json(['message' => 'offer updated successfully', 'offer' => $offer], 200);
}


public function delete_offer(Request $request)
{
    $offer = offer::find($request->id);

    if (!$offer) {
        return response()->json(['message' => 'offer not found'], 404);
    }

    $offer->delete();

    return response()->json(['message' => 'offer deleted successfully'], 200);
}



protected function updateOffers()
{
    // الحصول على جميع العروض
    $offers = Offer::all();

    foreach ($offers as $offer) {
        // حساب الفرق بين تاريخ الإضافة والتاريخ الحالي
        $created_at = Carbon::parse($offer->created_at);
        $now = Carbon::now();
        $daysPassed = $created_at->diffInDays($now);

        // تقليل عدد الأيام المتبقية
        $offer->days -= $daysPassed;

        // حذف العرض إذا كانت الأيام صفر أو أقل
        if ($offer->days <= 0) {
            $offer->delete();
        } else {
            // حفظ التغييرات إذا لم يتم الحذف
            $offer->save();
        }
    }
}

public function my_bills(Request $request)
    {

        $provider = auth('provider-api')->user();
       $bills =  Bill::where('provider_id', $provider->id)
       ->orderBy('created_at', 'desc')
       ->get();
        return response()->json(['my_bills' => $bills], 200);
    }

    public function bills_value()
    {
        // جميع الفواتير
        $bills = bill::all();

        // حساب عدد الفواتير
        $totalInvoicesCount = $bills->count();

        // حساب القيمة الإجمالية للفواتير
        $totalInvoicesAmount = $bills->sum('cost');

        // الفواتير المدفوعة
        $paidInvoices = $bills->where('state', 1);

        // عدد الفواتير المدفوعة
        $paidInvoicesCount = $paidInvoices->count();

        // القيمة الإجمالية للفواتير المدفوعة
        $paidInvoicesAmount = $paidInvoices->sum('cost');

        // إرجاع البيانات كاستجابة JSON
        return response()->json([
            'bills_count' => $totalInvoicesCount,
            'total_bills_cost' => $totalInvoicesAmount,
            'paid_amount' => $paidInvoicesAmount,
            'bills' => $bills
        ],200);
    }
}






