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

class maintenance_controller extends Controller
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

public function provider_request(Request $request)
{
    // الحصول على معرف المزود من المستخدم الذي قام بتسجيل الدخول
    $providerId = auth('employe-api')->user()->provider_id;

    // العثور على المزود باستخدام معرفه
    $provider = provider::find($providerId);

    // الحصول على العملاء الذين لديهم box_number يساوي صفر
    $clients = $provider->clients()->where('box_number', 0)->get();

    return response()->json(['clients' => $clients], 200);
}

public function confirm_request(Request $request)
{
    // التحقق من صحة البيانات المرسلة
    $validator = Validator::make($request->all(), [
        'client_id' => 'required|integer|exists:clients,id',
        'box_number' => 'required|integer',
    ]);

    // إذا فشلت عملية التحقق من البيانات، إرجاع الأخطاء
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // البحث عن العميل باستخدام client_id
    $client = Client::find($request->client_id);

    // تحديث قيمة box_number للعميل
    $client->box_number = $request->box_number;
    $client->save();

    return response()->json(['message' => 'Box number updated successfully', 'client' => $client], 200);
}

public function my_company(Request $request)
{

    $provider_id = auth('employe-api')->user()->provider_id;
    $provider = provider::find($provider_id );
    return response()->json(['my_company' => $provider], 200);
}



}
