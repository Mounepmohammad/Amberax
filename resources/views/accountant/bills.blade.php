<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
  <title>فواتيري</title>
</head>

<body>
  <div class="container">
    <div class="row p-4 rounded-4 m-2 text-center d-flex justify-content-around" dir="rtl"
      style="background-color: rgb(233, 232, 232);">
      <div class="col-2"><i class="fas fa-address-book" style="font-size: 35px; color: rgb(4, 79, 102)"></i></div>
      <input type="search" class="col-10 fs-5 rounded-3 px-5 py-2" placeholder="أحمد السعيد أو من خلال رقم المشترك 123"
        style="border: 1px solid #eee ;outline: 0; " />
    </div>
    <div class="row p-1 rounded-4 text-center" dir="rtl">
      <img src="../assets/images/six.png" alt="" class="w-75 img-fluid">
    </div>
    <div class="row px-1" dir="rtl">
      @foreach ($bills as $bill)
      <div class="col-lg-4 col-md-6 my-1">
        <div class="card">
          <p class="btn btn-primary" style="background-color: rgb(4, 79, 102);">رقم الفاتورة: {{ $bill->id }}</p>
          <div class="card-body">
            <p class="m-0 p-0">الاسم: {{ $bill->user->clients->first()->name }}</p>
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
            <div class="w-100 text-center">
              @if ($bill->photo)
              <a href="{{ asset('storage/' . $bill->photo) }}" target="_blank" class="btn btn-primary btn-rounded py-1 text-white">
                <i class="fas fa-file-alt"></i> <!-- FontAwesome Icon -->
            </a>              @else
              <p>لا توجد صورة</p>
              @endif
            </div>
            <hr>

            <p class="btn btn-primary w-100 text-center" style="background-color: rgb(4, 79, 102);">
              قيمة الفاتورة: {{ $bill->cost }} ليرة سورية
            </p>
            {{-- <a href="{{ route('confirm_payment', ['bill' => $bill->id]) }}" class="btn btn-primary w-100 text-center" style="background-color: rgb(4, 79, 102);">تأكيد دفع الفاتورة</a> --}}
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- js libraries -->
  @include('admin.layout.footer_scripts')
</body>

</html>
