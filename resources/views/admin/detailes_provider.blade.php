@extends('admin.master')

@section('content')

<div class="container-fluid d-flex justify-content-center w-100">
    <div class="row p-3">
        <div class="my-1 text-center">
            <p class="text-end fs-4 fw-bold p-2" dir="rtl">معلومات المزود :</p>
            <!-- عرض صورة المزود -->
            {{-- <img src="{{ asset('storage/' . $provider->photo) }}" alt="Provider Photo" class="img-fluid w-50 my-1"> --}}
        </div>
        <form dir="rtl" class="container-fluid my-1">
            <!-- أسم الشركة -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example3">أسم الشركة :</label>
                <input type="text" id="form6Example3" class="form-control" value="{{ $provider->name }}" disabled />
            </div>

            <!-- منطقة التخديم -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example4">منطقة التخديم :</label>
                <input type="text" id="form6Example4" class="form-control" value="{{ $provider->area }}" disabled />
            </div>

            <!-- رسوم التأمين -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example4">رسوم التأمين :</label>
                <input type="text" id="form6Example4" class="form-control" value="{{ $provider->feez }}" disabled />
            </div>

            <!-- الأحياء المخدمة -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example4">الأحياء المخدمة :</label>
                <div class="w-100 form-control" style="background-color: #eee; height: fit-content;">
                    {{ $provider->streets }}
                </div>
            </div>

            <!-- البريد الإلكتروني -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example5">البريد الألكتروني</label>
                <input type="email" id="form6Example5" class="form-control" value="{{ $provider->email }}" disabled />
            </div>

            <!-- كلمة السر -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example6">كلمة السر :</label>
                <input type="text" id="form6Example6" class="form-control" value="{{ $provider->password }}" disabled />
            </div>

            <!-- الهاتف الثابت -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example6">الهاتف الثابت :</label>
                <input type="tel" id="form6Example6" placeholder="011-629-123" class="form-control text-end" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="10" value="{{ $provider->phone }}" disabled />
            </div>

            <!-- الهاتف المحمول -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example6">الهاتف المحمول :</label>
                <input type="tel" id="form6Example6" class="form-control text-end" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" maxlength="10" placeholder="0932-123-456" value="{{ $provider->phone2 }}" disabled>
            </div>

            <!-- ملف PDF لرخصة الشركة -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example6">ملف بصيغة PDF لرخصة الشركة :</label>
                <a href="{{ asset('storage/' . $provider->license) }}" download="{{ basename($provider->license) }}">Download file</a>
            </div>

            <!-- صورة هوية مالك المزود -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form6Example6">صورة هوية مالك المزود :</label>
                <div><img src="{{ asset('storage/' . $provider->photo) }}" alt="Provider ID Photo" class="img-fluid w-50 my-1"></div>
            </div>

            <!-- معلومات أخرى عن الشركة -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example7">معلومات أخرى عن الشركة :</label>
                <div class="form-control" id="form6Example7" style="background-color: #eee; height: fit-content;">
                    {{ $provider->other_info ?? 'لا توجد معلومات إضافية' }}
                </div>
            </div>
            <!-- الأزرار -->
            <div class="row d-flex justify-content-around">
                <div class="col-3 ">
                    <a data-mdb-ripple-init href="{{ route('edit-provider', $provider->id) }}" class="btn btn-primary btn-block mb-4 text-center align-items-center w-100">تعديل معلومات المزود</a>
                </div>

                <div class="col-3">
                    <a data-mdb-ripple-init href="{{ route('data-subscribers', $provider->id) }}" class="btn btn-warning btn-block mb-4 text-center align-items-center w-100">المشتركين</a>
                </div>

                <div class="col-3 ">
                    <a data-mdb-ripple-init href="{{ route('data-employees', $provider->id) }}" class="btn btn-success btn-block mb-4 text-center align-items-center w-100">الموظفين</a>
                </div>

                <div class="col-3 ">
                    <a data-mdb-ripple-init href="{{ route('invioces-paid', $provider->id) }}" class="btn btn-danger btn-block mb-4 text-center align-items-center w-100">الفواتير</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
