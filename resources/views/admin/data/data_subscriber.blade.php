@extends('admin.master')

@section('content')
<div class="container">
  <div class="my-1">
    <p class="text-end fs-4 fw-bold p-2" dir="rtl">المشتركين لدى مزود {{$providerName}} :</p>

</div>
    <table class="table align-middle mb-0 bg-white" dir="rtl">
    <thead class="bg-light">
      <tr>
        <th>أسم المشترك </th>
        <th>عنوان أقامة المشترك</th>
        <th> صورة الهوية</th>
        <th>رقم العداد</th>


      </tr>
    </thead>
    <tbody >
        @foreach($clients as $client)
        <tr>
            <td>
                <div class="d-flex align-items-center px-2">
                    <img
                        src="{{ $client->photo ? asset('storage/' . $client->photo) : 'https://mdbootstrap.com/img/new/avatars/8.jpg' }}"
                        alt="Employee Photo"
                        style="width: 45px; height: 45px"
                        class="rounded-circle"
                    />
                    <div class="ms-3 px-3">
                        <p class="fw-bold mb-1">{{ $client->client_name }}</p>

                    </div>
                </div>
            </td>
            <td>
                <p class="fw-normal mb-1">{{ $client->address }}</p>
            </td>
            <td>
                <a href="{{ asset('storage/' . $client->id_photo) }}" target="_blank" class="btn btn-primary btn-rounded py-1 text-white">
                    <i class="fas fa-file-alt"></i> <!-- FontAwesome Icon -->
                </a>
            </td>

            <td>
                <p class="text-muted mb-0 text-center">{{ $client->counter }}</p>
            </td>
        </tr>
        @endforeach

    </tbody>
  </table>
</div>

@endsection
