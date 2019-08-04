@extends('role_permission.main')

@section('title')
{{ __('Role list') }}
@endsection

@section('content')
<div class="py-3">
  <h2>{{ __('Role list') }}</h2>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
  {{ $message }}
</div>
@endif

@can('Create role')
<p><a class="btn btn-success" href="{{ route('roles.create') }}"> {{ __('Create new role') }} </a></p>
@endcan

<div class="table-responsive">
  <table class="table table-striped">
    <thead class="thead-light">
      <tr>
        <th scope="col">{{ __('No.') }}</th>
        <th scope="col">{{ __('Role name') }}</th>
        <th scope="col">{{ __('Guard name') }}</th>
        <th scope="col">{{ __('Permission') }}</th>
        <th scope="col">{{ __('Action') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($roles as $role)
      <tr>
        <td scope="row">{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>{{ $role->guard_name }}</td>
        <td>
          @if(!empty($role->getPermissionNames()))
          <ul>
            @foreach($role->getPermissionNames() as $v)
            <li>{{ $v }}</li>
            @endforeach
          </ul>
          @endif
        </td>
        <td>
          <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">{{ __('Show') }}</a>
          <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">{{ __('Edit') }}</a>
          <a class="btn btn-danger" href="{{ route('roles.destroy', $role->id) }}" data-toggle="modal" onclick="deleteContent('{{ route('roles.destroy', $role->id) }}')" data-target="#DeleteModal">{{ __('Delete') }}</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="custom-pagination">
    <nav>
      {{ $roles->links() }}
    </nav>
  </div>

  <!-- Delete Modal -->
  @include('role_permission.delete-modal')
</div>
@endsection

@section('footer-scripts')

<!--Delete content
============================================ -->
<script src="{{ asset('js/custom/delete-content.js') }}"></script>

@endsection
