<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\provider;
use App\Models\user_req;
use App\Models\complaint;
use App\Models\bill;
use Validator;

class user2_controller extends Controller
{
   /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

     // عرض جميع المزودين
     public function providers()
     {
         $providers = Provider::all();
         return response()->json(['providers' => $providers], 200);
     }

     public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'words' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $words = $request->words;

        $providers = Provider::where(function($q) use ($words) {
            $q->where('name', 'LIKE', '%' . $words . '%')
                ->orWhere('area', 'LIKE', '%' . $words . '%')
                ->orWhere('streets', 'LIKE', '%' . $words . '%')
                ->orWhere('feez', 'LIKE', '%' . $words . '%')
                ->orWhere('cost_pk', 'LIKE', '%' . $words . '%');
        })->get();

        return response()->json(['providers' => $providers], 200);
    }

    public function subscribe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'provider_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $provider = provider::find($request->provider_id);
        if (!$provider) {
            return response()->json(['message' => 'provider not found'], 404);
        }


        $existingSubscription = user_req::where('user_id', auth('api')->user()->id )
        ->where('provider_id', $request->provider_id)
        ->first();

    if ($existingSubscription) {
        return response()->json(['message' => 'You have already subscribed to this provider'], 422);
    }



        $user_req = user_req::create(array_merge(
            $validator->validated(),
            [
                'user_id'=>auth('api')->user()->id ,
            ]
        ));
        return response()->json(['message' => 'Your request is don sucssess'], 200);


    }


    public function provider_complaints(Request $request)
    {
        $provider_id = auth('api')->user()->clients()->first()->provider_id;
        $provider = provider::find($provider_id);
        if (!$provider) {
            return response()->json(['message' => 'provider not found'], 404);
        }
        return response()->json(['complaints' => $provider->complaints()->with('responses')->get()], 200);
    }



    public function provider_offers(Request $request)
    {
        $provider_id = auth('api')->user()->clients()->first()->provider_id;
        $provider = provider::find($provider_id);
        if (!$provider) {
            return response()->json(['message' => 'provider not found'], 404);
        }
        return response()->json(['offers' => $provider->offers()->get()], 200);
    }


    public function my_complaints(Request $request)
    {
      return response()->json(['my_complaints' => auth('api')->user()->complaints()->with('responses')->get()], 200);
    }


    public function add_complaint(Request $request)
{
    $validator = Validator::make($request->all(), [
        'descreption' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }
    $provider_id = auth('api')->user()->clients()->first()->provider_id;
    $provider = provider::find($provider_id);
    if (!$provider) {
        return response()->json(['message' => 'provider not found'], 404);
    }

    $complaint = Complaint::create(array_merge(
        $validator->validated(),
        [
            'user_id'=>auth('api')->user()->id,
            'provider_id' =>$provider_id,

        ]
    ));

    return response()->json(['message' => 'Complaint added successfully', 'complaint' => $complaint], 201);
}



public function update_complaint(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id'=>'required|exists:complaints,id',
        'descreption' => 'sometimes|required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $complaint = Complaint::find($request->id);
    if (!$complaint) {
        return response()->json(['message' => 'Complaint not found'], 404);
    }

    $complaint->update($validator->validated());

    return response()->json(['message' => 'Complaint updated successfully', 'complaint' => $complaint], 200);
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

public function my_bills(Request $request)
{

    $user_id = auth('api')->user()->id;
    // استرجاع الفواتير المدفوعة المرتبطة بـ provider_id
    $bills = Bill::where('user_id', $user_id)
                ->orderBy('created_at', 'desc') // ترتيب حسب الأحدث
                ->get();

    return response()->json(['bills' => $bills], 200);
}



}
