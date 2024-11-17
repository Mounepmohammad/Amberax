@extends('admin.master')

@section('content')
<div class="container-fluid d-flex justify-content-center w-100">
    <div class="row p-3">
        <div class="my-1 text-center">
            <img src="{{ asset('storage/' . $provider->photo) }}" alt="Provider Photo" class="img-fluid w-50">
        </div>
        <form dir="rtl" class="container-fluid my-1" method="POST" action="{{ route('update-provider', $provider->id) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Company Name -->
            <div class="form-outline mb-4">
                <label class="form-label" for="name">أسم الشركة:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $provider->name) }}" />
            </div>

            <!-- Service Area -->
            <div class="form-outline mb-4">
                <label class="form-label" for="area">منطقة التخديم:</label>
                <input type="text" id="area" name="area" class="form-control" value="{{ old('area', $provider->area) }}" />
            </div>

            <!-- Streets (Neighborhoods) -->
            <div class="form-outline mb-4">
                <label class="form-label" for="streets">الأحياء المخدمة:</label>
                <input type="text" id="streets" name="streets" class="form-control" value="{{ old('streets', $provider->streets) }}" />
            </div>

            <!-- Email -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">البريد الألكتروني:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $provider->email) }}" />
            </div>

            <!-- Password -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">كلمة السر:</label>
                <input type="password" id="password" name="password" class="form-control" value="{{ old('password', $provider->password) }}" />
            </div>

            <!-- Landline Phone -->
            <div class="form-outline mb-4">
                <label class="form-label" for="phone">الهاتف الثابت:</label>
                <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', $provider->phone) }}" placeholder="011-629-1234"  />
            </div>

            <!-- Mobile Phone -->
            <div class="form-outline mb-4">
                <label class="form-label" for="phone2">الهاتف المحمول:</label>
                <input type="tel" id="phone2" name="phone2" class="form-control" value="{{ old('phone2', $provider->phone2) }}" placeholder="0932-123-456"  />
            </div>


            <!-- Cost per KM -->
            <div class="form-outline mb-4">
                <label class="form-label" for="feez">رسم التامين  :</label>
                <input type="text" id="feez" name="feez" class="form-control" value="{{ old('feez', $provider->feez) }}" />
            </div>

            <!-- Cost per KM -->
            <div class="form-outline mb-4">
                <label class="form-label" for="cost_pk">تكلفة الكيلو :</label>
                <input type="text" id="cost_pk" name="cost_pk" class="form-control" value="{{ old('cost_pk', $provider->cost_pk) }}" />
            </div>

            <!-- Company License PDF -->
            <div class="form-outline mb-4">
                <label class="form-label" for="license">ملف بصيغة PDF لرخصة الشركة:</label>
                <input type="file" id="license" name="license" class="form-control" accept=".pdf" />
                @if($provider->license)
                    <a href="{{ asset('storage/' . $provider->license) }}" download="{{ basename($provider->license) }}">تحميل الملف الحالي</a>
                @endif
            </div>

            <!-- Owner ID Photo -->
            <div class="form-outline mb-4">
                <label class="form-label" for="photo">صورة هوية مالك الشركة المزودة:</label>
                <input type="file" id="photo" name="photo" class="form-control" accept=".png,.gif,.jpeg" />
                <div><img src="{{ asset('storage/' . $provider->photo) }}" alt="Provider ID Photo" class="img-fluid w-50 my-1"></div>
            </div>

            <!-- Submit button -->
            <div class="align-items-center">
                <button type="submit" class="btn btn-primary btn-block mb-4 text-center align-items-center">حفظ التعديلات</button>
            </div>
        </form>
    </div>
</div>
@endsection
