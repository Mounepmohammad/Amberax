<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Employe;
use App\Models\Bill;
use App\Models\client;
use Illuminate\Http\Request;

class accountent_wep_controller extends Controller
{

    //  /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct() {
    //     $this->middleware('employe_auth:employe-api');
    // }

    public function accountant($id)
    {
        // جلب معلومات المحاسب الحالي
        $accountant = employe::find($id);// نفترض أن الموظف مسجل الدخول باستخدام الـ guard المناسب
        // if (!$accountant) {
        //     return redirect()->route('start');
        // }
        // جلب معلومات الشركة المرتبطة بالمحاسب
        $provider = $accountant->provider; // يجب أن تكون هناك علاقة بين الموظف والشركة في موديل Employe

        // جلب الفواتير المدفوعة من قبل المحاسب
        $bills = Bill::where('provider_id', $accountant->provider_id)
                    ->where('state', 1)
                    ->get();

        // حساب عدد الفواتير وقيمتها الإجمالية
        $totalBills = $bills->count();
        $totalAmount = $bills->sum('cost');

        return view('accountant.accountant', compact('accountant', 'provider', 'bills', 'totalBills', 'totalAmount'));
    }



    public function clients($id)
    {
        // استرجاع المشتركين بناءً على provider_id
        $clients = client::where('provider_id', $id)->get();

        return view('accountant.clients', ['subscribers' => $clients]);
    }

    public function bills($id)
    {
        // استرجاع المشتركين بناءً على provider_id
        $bills =  Bill::where('provider_id', $id)->where('state', 1)->with(['user.clients'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('accountant.bills', ['bills' => $bills]);
    }

    public function client_bills($id)
    {
        // استرجاع المشتركين بناءً على provider_id
        $client = client::find($id);

        $bills =  Bill::where('user_id', $client->user_id)->with(['user.clients'])
        ->orderBy('state', 'asc')  // 0 (غير مدفوعة) قبل 1 (مدفوعة)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('accountant.invoices_subscriber', ['bills' => $bills]);
    }

    public function pay_bill($id)
    {
        // استرجاع المشتركين بناءً على provider_id

        $bill = bill::find($id);
        $bill->state = 1 ;
        $bill->save();

        $bills =  Bill::where('user_id', $bill->user_id)->with(['user.clients'])
        ->orderBy('state', 'asc')  // 0 (غير مدفوعة) قبل 1 (مدفوعة)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('accountant.invoices_subscriber', ['bills' => $bills]);
    }

}
