<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider;
use App\Models\employe;
use App\Models\user_req;
use App\Models\client;
use App\Models\complaint;
use App\Models\offer;
use App\Models\user;
use App\Models\bill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;

class collector_controller extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('employe_auth:employe-api');
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

        $clients = client::where(function($q) use ($words) {
            $q->where('client_name', 'LIKE', '%' . $words . '%')
                ->orWhere('address', 'LIKE', '%' . $words . '%')
                ->orWhere('counter', 'LIKE', '%' . $words . '%');

        })->get();

        return response()->json(['clients' => $clients], 200);
    }

    public function clients(Request $request)
{

    $provider = auth('employe-api')->user()->provider_id;
    $provider = provider::find($provider);
   $clients =  $provider->clients()->get();
    return response()->json(['clients' => $clients], 200);
}

public function client_bills(Request $request)
{
    $validator = Validator::make($request->all(), [
        'client_id' => 'required|integer',
    ]);
   // $provider = auth('employe-api')->user()->provider_id;
    $client = client::find($request->client_id);
   $user_id =  $client->user_id;
    $user = user::find($user_id);
    $client_bills = $user->bills()->get();
    return response()->json([
        'client_bills' => $client_bills,
        'client'=>$client
], 200);
}
public function add_bill(Request $request)
    {
        // التحقق من المدخلات
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'new_value' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10000', // الصورة اختيارية
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $provider = auth('employe-api')->user()->provider_id;
        $provider_id = provider::find($provider)->id;

        $client = client::find($request->client_id);
        $user_id =  $client->user_id;
         //$user_id =  $user->id;

        // البحث عن الفاتورة السابقة للمستخدم مع نفس المزود
        $previousBill = Bill::where('user_id', $user_id)
                            ->where('provider_id', $provider_id)
                            ->orderBy('created_at', 'desc')
                            ->first();

        // إذا كانت هناك فاتورة سابقة، استخدم قيمة العداد الجديدة كقيمة قديمة للفاتورة الجديدة
        $oldValue = $previousBill ? $previousBill->new_value : 0;

        if($request->new_value - $oldValue <0){

            return response()->json(['message' => 'new value must be greater than old value',], 201);
        }

        // حساب استهلاك الطاقة
        $consumption = $request->new_value - $oldValue;


        $latestOffer = Offer::where('provider_id', $provider_id)
        ->orderBy('created_at', 'desc')
        ->first();

        $cost_pk = $latestOffer ? $latestOffer->cost_pk : Provider::find($provider_id)->cost_pk;
        // البحث عن تكلفة الـkWh الخاصة بالشركة
        $provider = Provider::find($provider_id);
        $cost = $consumption * $cost_pk;

        // رفع الصورة إذا كانت موجودة
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('bill_photos', 'public');
        }

        // إنشاء الفاتورة الجديدة
        $bill = Bill::create([
            'user_id' => $user_id,
            'provider_id' => $provider_id,
            'old_value' => $oldValue,
            'new_value' => $request->new_value,
            'cost' => $cost,
            'photo' => $photoPath,
            'state' => 0, // الفاتورة تبدأ بحالة غير مدفوعة
        ]);

        return response()->json(['message' => 'Bill created successfully', 'bill' => $bill], 201);
    }

    public function my_bills(Request $request)
    {

        $provider = auth('employe-api')->user()->provider_id;
        $provider_id = provider::find($provider)->id;
       $bills =  Bill::where('provider_id', $provider_id)
       ->orderBy('created_at', 'desc')
       ->get();
        return response()->json(['my_bills' => $bills], 200);
    }




    public function update_bill(Request $request)
{
    // التحقق من المدخلات
    $validator = Validator::make($request->all(), [
        'bill_id'=>'required',
        'new_value' => 'sometimes|required|integer|min:0',
        'photo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // البحث عن الفاتورة المطلوبة
    $bill = Bill::find($request->bill_id);
    if (!$bill) {
        return response()->json(['message' => 'Bill not found'], 404);
    }

    if ($bill->state == 1) {
        return response()->json(['message' => 'can not update now'], 404);
    }
    // تحديث القيمة القديمة إذا تم إدخال قيمة جديدة
    if ($request->has('new_value')) {
        // البحث عن الفاتورة السابقة للمستخدم مع نفس المزود
        $previousBill = Bill::where('user_id', $bill->user_id)
                            ->where('provider_id', $bill->provider_id)
                            ->where('id', '<', $bill->id)
                            ->orderBy('created_at', 'desc')
                            ->first();

        // إذا كانت هناك فاتورة سابقة، استخدم قيمة العداد الجديدة كقيمة قديمة للفاتورة الجديدة
        $oldValue = $previousBill ? $previousBill->new_value : 0;

        if($request->new_value - $oldValue <0){

            return response()->json(['message' => 'new value must be greater than old value',], 201);
        }
        // حساب استهلاك الطاقة
        $consumption = $request->new_value - $oldValue;

        // البحث عن العرض الأحدث للمزود
        $offer = Offer::where('provider_id', $bill->provider_id)
                      ->orderBy('created_at', 'desc')
                      ->first();

        // إذا كان هناك عرض استخدم `cost_pk` منه، وإلا استخدم تكلفة الشركة
        $costPk = $offer ? $offer->cost_pk : $bill->provider->cost_pk;

        // حساب التكلفة الجديدة
        $cost = $consumption * $costPk;

        // تحديث الفاتورة
        $bill->update([
            'old_value' => $oldValue,
            'new_value' => $request->new_value,
            'cost' => $cost,
        ]);
    }

    // تحديث الصورة إذا تم إدخال صورة جديدة
    if ($request->hasFile('photo')) {
        // حذف الصورة القديمة إذا كانت موجودة
        if ($bill->photo) {
            Storage::disk('public')->delete($bill->photo);
        }

        // رفع الصورة الجديدة
        $photoPath = $request->file('photo')->store('bill_photos', 'public');
        $bill->update(['photo' => $photoPath]);
    }

    return response()->json(['message' => 'Bill updated successfully', 'bill' => $bill], 200);
}

public function my_company(Request $request)
{

    $provider_id = auth('employe-api')->user()->provider_id;
    $provider = provider::find($provider_id );
    return response()->json(['my_company' => $provider], 200);
}



}
