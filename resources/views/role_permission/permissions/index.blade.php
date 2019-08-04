@extends('role_permission.main')

@section('title')
{{ __('Permission list') }}
@endsection

@section('content')
<div class="py-3">
  <h2>{{ __('Permission list') }}</h2>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

@can('Create permission')
    <p><a class="btn btn-success" href="{{ route('permissions.create') }}"> {{ __('Create new permission') }} </a></p>
@endcan

<div class="table-responsive">
  <table class="table table-striped">
    <thead class="thead-light">
      <tr>
        <th scope="col">{{ __('No.') }}</th>
        <th scope="col">{{ __('Permission name') }}</th>
        <th scope="col">{{ __('Guard name') }}</th>
        <th scope="col">{{ __('Group') }}</th>
        <th scope="col">{{ __('Role') }}</th>
        <th scope="col">{{ __('Action') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($permissions as $permission)
      <tr>
        <td scope="row">{{ ++$i }}</td>
        <td>{{ $permission->name }}</td>
        <td>{{ $permission->guard_name }}</td>
        <td>{{ $permission->group }}</td>
        <td>
          @if(!empty($permission->getRoleNames()))
              <ul>
                @foreach($permission->getRoleNames() as $v)
                  <li>{{ $v }}</li>
                @endforeach
              </ul>
          @endif
        </td>
        <td>
          <a class="btn btn-info" href="{{ route('permissions.show', $permission->id) }}">{{ __('Show') }}</a>
          <a class="btn btn-primary" href="{{ route('permissions.edit', $permission->id) }}">{{ __('Edit') }}</a>
          <a class="btn btn-danger" href="{{ route('permissions.destroy', $permission->id) }}" data-toggle="modal" onclick="deleteContent('{{ route('permissions.destroy', $permission->id) }}')" data-target="#DeleteModal">{{ __('Delete') }}</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="custom-pagination">
    <nav>
      {{ $permissions->links() }}
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
