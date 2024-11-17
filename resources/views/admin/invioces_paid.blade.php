@extends('admin.master')

@section('content')

<div class="container" dir="rtl">

    <div class="col-6">
        <a data-mdb-ripple-init href="{{ route('invioces-paid',$providerId ) }}" class="btn btn-warning btn-block mb-4 text-center align-items-center w-100">الفواتير المدفوعة</a>
    </div>
    <div class="col-6">
        <a data-mdb-ripple-init href="{{ route('invioces-not-paid',$providerId ) }}" class="btn btn-warning btn-block mb-4 text-center align-items-center w-100">الفواتير غير المدفوعة</a>
    </div>
    <div class="row bg-success w-75 text-center text-white d-flex flex-center m-auto rounded-3 my-4 d-flex justify-content-around">
        <p>عدد الفواتير المدفوعة : {{ $count }}</p>
        <p>قيمتها : {{ $amount }} ليرة سورية</p>
    </div>

    <div class="row my-2">
        @foreach ($bills as $bill)
        <div class="col-4">
            <div class="card">
                <p class="btn btn-success">رقم الفاتورة: {{ $bill->id }}</p>
                <div class="card-body">
                    <p class="m-0 p-0">الاسم: {{ $bill->user->clients->first()->client_name }}</p>
                    <hr>
                    <p class="card-text">عنوان السكن: {{ $bill->user->clients->first()->address }}</p>
                    <hr>
                    <p class="card-text">رقم الصندوق: {{ $bill->user->clients->first()->box_number }}</p>
                    <hr>
                    <p class="card-text">رقم العداد: {{ $bill->user->clients->first()->counter }}</p>
                    <hr>
                    <p class="card-text">التاريخ: {{ $bill->created_at->format('d/m/Y') }}</p>
                    <hr>
                    <p class="card-text">الفاتورة:</p>
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
                    <div class="text-center">
                        <a href="{{ asset('storage/' . $bill->photo) }}" target="_blank" class="btn btn-primary btn-rounded py-1 text-white">
                            <i class="fas fa-file-alt"></i> <!-- FontAwesome Icon -->
                        </a>
                    </div>
                    <p class="btn btn-success w-100 text-center">قيمة الفاتورة: {{ $bill->cost }} ليرة سورية</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
