<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <title>قسم المحاسبة</title>
</head>
<body>
    <div class="container-fluid my-3">
        <div class="row p-4 rounded-4 m-2 text-center d-flex justify-content-around" dir="rtl" style="background-color: rgb(233, 232, 232);">
            <div class="col-2">
                <i class="fas fa-address-book" style="font-size: 35px; color: rgb(4, 79, 102)"></i>
            </div>
            <div class="col-10 fs-5 fw-bold">المحاسب : {{ $accountant->name }}</div>
        </div>
        <div class="row text-white p-4 rounded-4 m-2 d-flex justify-content-around" dir="rtl" style="background-color: rgb(4, 79, 102);">
            <div class="col-12 fs-3 fw-bold px-3">مزود {{ $provider->name }}</div>
            <div class="col-12 fs-5 px-3">على جميع موظفي المحاسبة محاسبة الفواتير اليوم</div>
        </div>
        <div class="row">
            <div class="col-6">
                <a href="{{ route('clients' ,$provider->id ) }}">
                    <div class="row text-center text-white p-2 rounded-4 m-1 d-flex justify-content-center py-2" dir="rtl" style="background-color: rgb(4, 79, 102);">
                        <div class="col-8 fs-5 fw-bold px-2">المشتركين لدى المزود</div>
                        <div class="col-4 fs-5 px-1"><img src="{{ asset('assets/img/Discover.svg') }}" alt="" class="img-fluid"></div>
                    </div>
                </a>
            </div>

            <div class="col-6">
                <a href="{{ route('bills' , $provider->id) }}">
                    <div class="row text-center text-white p-2 rounded-4 m-1 d-flex justify-content-center py-2" dir="rtl" style="background-color: rgb(4, 79, 102);">
                        <div class="col-8 fs-5 fw-bold px-2">فواتيري</div>
                        <div class="col-4 fs-5 px-1"><img src="{{ asset('assets/img/Flash Icon.svg') }}" alt="" class="img-fluid"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row text-white p-4 rounded-4 m-2 d-flex justify-content-around" dir="rtl" style="background-color: rgb(4, 79, 102);">
            <div class="col-12 fs-4 fw-normal px-3 py-1 rounded-3 text-center" style="background-color:#fff; color: rgb(4, 79, 102);">
                إحصائيات كل الفواتير المدفوعة التي حاسبها المحاسب
            </div>
            <div class="col-12 fs-5 py-2 px-5">عددها : {{ $totalBills }} فاتورة.</div>
            <div class="col-12 fs-5 py-2 px-5">قيمة الفواتير : {{ number_format($totalAmount) }} ليرة سورية.</div>
        </div>

        <div class="row px-2" dir="rtl">
            @foreach ($bills as $bill)
                <div class="col-lg-3 col-md-4">
                    <div class="card">
                        <p class="btn btn-primary" style="background-color: rgb(4, 79, 102);">رقم الفاتورة: {{ $bill->id }}</p>
                        <div class="card-body">
                            <p class="m-0 p-0">الاسم : {{ $bill->user->clients->first()->client_name }}</p>
                            <hr>
                            <p class="card-text">عنوان السكن : {{ $bill->user->clients->first()->address }}</p>
                            <hr>
                            <p class="card-text">رقم الصندوق : {{ $bill->user->clients->first()->box_number }}</p>
                            <hr>
                            <p class="card-text">رقم العداد : {{ $bill->user->clients->first()->counter }}</p>
                            <hr>
                            <p class="card-text">التاريخ : {{ $bill->created_at->format('d/m/Y') }}</p>
                            <hr>
                            <p class="card-text">الفاتورة :</p>
                            <div class="row text-center">
                                <div class="col-4">
                                    <p>القديمة</p>
                                    <div>{{ $bill->old_value }}</div>
                                </div>
                                <div class="col-4">
                                    <p>الجديدة</p>
                                    <div>{{ $bill->new_value }}</div>
                                </div>
                                <div class="col-4">
                                    <p>الاستهلاك</p>
                                    <div>{{ $bill->new_value - $bill->old_value }}</div>
                                </div>
                            </div>
                            <hr>
                            <p class="card-text">صورة قيمة العداد</p>

                                <a href="{{ asset('storage/' . $bill->photo) }}" target="_blank" class="btn btn-primary btn-rounded py-1 text-white">
                                    <i class="fas fa-file-alt"></i> <!-- FontAwesome Icon -->
                                </a>

                            <hr class="mt-3">
                            <hr>
                            <p class="btn btn-primary w-100 text-center" style="background-color: rgb(4, 79, 102);">قيمة الفاتورة {{ number_format($bill->cost) }} ليرة سورية</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- js librareis -->
    @include('admin.layout.footer_scripts')
</body>
</html>
