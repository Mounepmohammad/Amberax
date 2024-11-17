<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <title>المشتركين</title>
</head>
<body>

    <div class="container">
        <div class="row p-4 rounded-4 m-2 text-center d-flex justify-content-around" dir="rtl"
            style="background-color: rgb(233, 232, 232);">
            <div class="col-1"><i class="fas fa-address-book" style="font-size: 35px; color: rgb(4, 79, 102)"></i></div>
            <div class="col-11 fs-5 fw-bold">المشتركين لدى المزود</div>
        </div>

        <table class="table align-middle mb-0 bg-white" dir="rtl">
            <thead class="bg-light">
                <tr>
                    <th>أسم المشترك والبريد الإلكتروني</th>
                    <th>رقم العداد </th>
                    <th>المنطقة</th>
                    <th>الإعدادات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscribers as $subscriber)
                <tr>
                    <td>
                        <div class="d-flex align-items-center px-2">
                            <img
                            src="{{ $subscriber->photo1 ? asset('storage/' . $subscriber->photo1) : 'https://mdbootstrap.com/img/new/avatars/8.jpg' }}"
                            alt="Employee Photo"
                            style="width: 45px; height: 45px"
                            class="rounded-circle"
                        />
                            <div class="ms-3 px-3">
                                <p class="fw-bold mb-1">{{ $subscriber->client_name }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="fw-normal mb-1">{{ $subscriber->counter }}</p>
                    </td>
                    <td>
                        <p class="text-muted mb-0">{{ $subscriber->address }}</p>
                    </td>
                    <td>
                        <a href="{{ route('client_bills', $subscriber->id) }}" class="btn btn-success btn-rounded">
                            فواتير المشترك
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- js libraries -->
    @include('admin.layout.footer_scripts')
</body>
</html>
