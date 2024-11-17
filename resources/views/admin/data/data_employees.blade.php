@extends('admin.master')

@section('content')
<div class="container">
    <div class="my-1">
        <p class="text-end fs-4 fw-bold p-2" dir="rtl">الموظفين لدى مزود {{ $providerName }} :</p>
    </div>
    <table class="table align-middle mb-0 bg-white" dir="rtl">
        <thead class="bg-light">
            <tr>
                <th>أسم الموظف والبريد الألكتروني</th>
                <th>عنوان إقامة الموظف</th>
                <th>نوع العمل</th>
                <th> صورة الهوية</th>
                <th>الرقم التعريفي للموظف</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>
                    <div class="d-flex align-items-center px-2">
                        <img
                            src="{{ $employee->photo1 ? asset('storage/' . $employee->photo1) : 'https://mdbootstrap.com/img/new/avatars/8.jpg' }}"
                            alt="Employee Photo"
                            style="width: 45px; height: 45px"
                            class="rounded-circle"
                        />
                        <div class="ms-3 px-3">
                            <p class="fw-bold mb-1">{{ $employee->name }}</p>
                            <p class="text-muted mb-0">{{ $employee->email }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="fw-normal mb-1">{{ $employee->address }}</p>
                </td>
                <td>
                    <p class="text-muted mb-0">
                        @switch($employee->type)
                            @case(0) جابي @break
                            @case(1) محاسب @break
                            @case(2) صيانة @break
                            @default نوع غير معروف
                        @endswitch
                    </p>
                </td>
                <td>
                    <a href="{{ asset('storage/' . $employee->photo) }}" target="_blank" class="btn btn-primary btn-rounded py-1 text-white">
                        <i class="fas fa-file-alt"></i> <!-- FontAwesome Icon -->
                    </a>
                </td>

                <td>
                    <p class="text-muted mb-0 text-center">{{ $employee->id }}</p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
