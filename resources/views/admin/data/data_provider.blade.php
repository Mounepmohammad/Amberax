@extends("admin.master")
@section('content')

<div class="container">

  <table class="table align-middle mb-0 bg-white" dir="rtl">
  <thead class="bg-light">
    <tr>
      <th>أسم الشركة والبريد الألكتنروني</th>
      <th>منطقة التخديم </th>
      <th>سعر الكيلو واط</th>
      <th>ملف الترخيص</th>
      <th>الأعدادات</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($providers as $provider)
        <tr>
          <td>
            <a href='#'>
            <div class="d-flex align-items-center px-2">
              <img
                  src="{{   $provider->photo1 ? asset('storage/' . $provider->photo1)  : 'https://mdbootstrap.com/img/new/avatars/8.jpg' }}"
                  alt="Provider Photo"
                  style="width: 45px; height: 45px"
                  class="rounded-circle"
              />
              <div class="ms-3 px-3">
                <p class="fw-bold mb-1">{{ $provider->name }}</p>
                <p class="text-muted mb-0">{{ $provider->email }}</p>
              </div>
            </div>
          </a>
          </td>
          <td>
            <p class="text-muted mb-0">{{ $provider->area }}</p>
          </td>
          <td>
            <p class="text-muted mb-0">{{ $provider->cost_pk }}</p>
          </td>
          <td>
              <a href="{{ asset('storage/' . $provider->license) }}" target="_blank" class="btn btn-primary btn-rounded py-1 text-white">
                  <i class="fas fa-file-alt"></i> <!-- FontAwesome Icon -->
              </a>
          </td>
          <td>
            <form action="{{ route('delete-provider') }}" method="POST" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <input type="hidden" name="id" value="{{ $provider->id }}">
              <button type="submit" class="btn btn-danger btn-rounded mx-1 fw-bold">حذف</button>
            </form>

            <a href="{{ route('detailes-provider', $provider->id) }}"  class="btn btn-warning btn-rounded mx-1 fw-bold">
              التفاصيل
            </a>
          </td>
        </tr>
    @endforeach
  </tbody>
</table>

</div>

@endsection
