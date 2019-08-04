@extends('role_permission.main')

@section('title')
{{ __('User list') }}
@endsection

@section('content')
<div class="py-3">
  <h2>{{ __('User list') }}</h2>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<div class="table-responsive">
  <table class="table table-striped">
    <thead class="thead-light">
      <tr>
        <th scope="col">{{ __('No.') }}</th>
        <th scope="col">{{ __('User ID') }}</th>
        <th scope="col">{{ __('Role') }}</th>
        <th scope="col">{{ __('Action') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <td scope="row">{{ ++$i }}</td>
        <td>{{ $user->id }}</td>
        <td>
              @if(!empty($user->getRoleNames()))
              <ul>
                @foreach($user->getRoleNames() as $v)
                    <li>{{ $v }}</li>
                @endforeach
              </ul>
              @endif
        </td>
        <td>
          <a class="btn btn-info" href="{{ route('user.role', $user->id) }}">{{ __('Update role') }}</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="custom-pagination">
    <nav>
      {{ $users->links() }}
    </nav>
  </div>

</div>
@endsection
