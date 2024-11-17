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

class accountent_controller extends Controller
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


public function pay_bill(Request $request)
{
    // التحقق من صحة البيانات المرسلة
    $validator = Validator::make($request->all(), [
        'bill_id' => 'required|integer|exists:bills,id',
    ]);

    // إذا فشلت عملية التحقق من البيانات، إرجاع الأخطاء
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // البحث عن العميل باستخدام client_id
    $bill = bill::find($request->bill_id);

    // تحديث قيمة box_number للعميل
    $bill->state = 1;
    $bill->save();

    return response()->json(['message' => 'bill is payed  successfully', 'bill' => $bill], 200);
}

public function my_bills(Request $request)
{

    $provider_id = auth('employe-api')->user()->provider_id;
    // استرجاع الفواتير المدفوعة المرتبطة بـ provider_id
    $bills = Bill::where('provider_id', $provider_id)
                ->where('state', 1) // فقط الفواتير المدفوعة
                ->orderBy('updated_at', 'desc') // ترتيب حسب الأحدث
                ->get();

    return response()->json(['bills' => $bills], 200);
}

}
