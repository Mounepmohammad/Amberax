@extends("admin.master")
@section('content')

<div class="container-fluid d-flex justify-content-center w-100">
    <div class="row p-3">
        <div class="my-1 text-center">
            <img src="{{asset('assets/img/home2.png')}}" alt="" class="img-fluid w-50 ">
        </div>
        <form dir="rtl" class="container-fluid my-1" method="POST" action="{{ route('add-provider')}}" enctype="multipart/form-data">
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

            <!-- Text input: Company Name -->
            <div class="form-outline mb-4">
                <label class="form-label" for="name">أسم الشركة :</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required />
            </div>

            <!-- Text input: Service Area -->
            <div class="form-outline mb-4">
                <label class="form-label" for="area">منطقة التخديم :</label>
                <input type="text" id="area" name="area" class="form-control" value="{{ old('area') }}" />
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">البريد الألكتروني</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">كلمة السر :</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>

            <!-- Landline Phone input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="phone">الهاتف الثابت : </label>
                <input type="tel" id="phone" name="phone" class="form-control text-end" value="{{ old('phone') }}" placeholder="011-629-1234" />
            </div>

            <!-- Mobile Phone input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="phone2">الهاتف المحمول :</label>
                <input type="tel" id="phone2" name="phone2" class="form-control text-end" value="{{ old('phone2') }}" placeholder="0932-123-456" />
            </div>
                <!-- Mobile Phone input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="cost_pk">سعر الكيلو  :</label>
                <input type="tel" id="cost_pk" name="cost_pk" class="form-control text-end" value="{{ old('cost_pk') }}" />
            </div>

            <!-- License File input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="license">ملف بصيغة PDF لرخصة الشركة :</label>
                <input type="file" id="license" name="license" class="form-control" accept=".pdf,.word,.png,.gif,.jpeg" />
            </div>

            <!-- Photo File input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="photo">صورة هوية مالك الشركة المزودة :</label>
                <input type="file" id="photo" name="photo" class="form-control" accept=".png,.gif,.jpeg" />
            </div>



            <!-- Submit button -->
            <div class="align-items-center">
                <button type="submit" class="btn btn-primary btn-block mb-4 text-center align-items-center">موافقة على أضافة شركة مزودة</button>
            </div>
        </form>
    </div>
</div>

@endsection
