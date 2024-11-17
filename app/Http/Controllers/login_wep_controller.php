<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class login_wep_controller extends Controller
{
    public function login(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // محاولة تسجيل الدخول كـ Admin
        if ($this->attemptLogin($validator->validated(), 'admin-api')) {
            return $this->redirectToDashboard('admin','admin-api');
        }

        // محاولة تسجيل الدخول كـ موظف محاسب (type = 2)
        if ($this->attemptLogin($validator->validated(), 'employe-api', 2)) {
            return $this->redirectToDashboard('employe','employe-api');
        }

        // إذا فشلت جميع المحاولات، إعادة التوجيه مع رسالة خطأ
        return redirect()->back()->with('error', 'Unauthorized');
    }

    private function attemptLogin($credentials, $guard, $employeType = null)
    {
        // محاولة تسجيل الدخول مع الحارس المحدد
        if (Auth::guard($guard)->attempt($credentials)) {
            $user = Auth::guard($guard)->user();

            // التحقق من نوع الموظف إذا كان الحارس هو "employe"
            if ($guard == 'employe-api' && $user->type != 2) {
                Auth::guard($guard)->logout();
                return false;
            }

            return true;
        }

        return false;
    }

    protected function redirectToDashboard($userType , $guard  )
    {
        $user = Auth::guard($guard)->user();
        switch ($userType) {
            case 'admin':

                return redirect()->route('dash');
            case 'employe':
                return redirect()->route('accountant' , $user->id);
            default:
                return redirect()->route('login')->with('error', 'Unauthorized');
        }
    }
}
