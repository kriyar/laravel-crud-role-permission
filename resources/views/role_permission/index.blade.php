@extends('role_permission.main')

@section('title')
{{ __('Role permission list') }}
@endsection

@section('content')
<div class="py-3">
  <h2>{{ __('Role permission list') }}</h2>
</div>

@if ($message = Session::get('warning'))
<div class="alert alert-warning">
  {{ $message }}
</div>
@elseif($message = Session::get('error'))
<div class="alert alert-error">
  {{ $message }}
</div>
@elseif ($message = Session::get('success'))
<div class="alert alert-success">
  {{ $message }}
</div>
@endif

<p>
  <a class="btn btn-success" href="{{ route('roles.create') }}"> {{ __('Create new role') }} </a>
  <a class="btn btn-success" href="{{ route('permissions.create') }}"> {{ __('Create new permission') }} </a>
</p>
<div>
  {!! Form::open(['route' => 'filter.role.permission', 'method'=>'POST']) !!}
  <div class="form-row">
    <div class="form-group col-md-2">
      <strong>{{ __('Role') }}:</strong>
      {!! Form::select('roles[]', $role_options, session('selected_filter_role_id'), ['class' => 'form-control', 'multiple' => true, 'size' => 8]); !!}
    </div>
    <div class="form-group col-md-2">
      <strong>{{ __('Group') }}:</strong>
      {!! Form::select('groups[]', $group_options, session('selected_filter_group'), ['class' => 'form-control', 'multiple' => true, 'size' => 8]); !!}
    </div>
    <div class="form-group col-md-2">
      <br /><button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
    </div>
  </div>
  {!! Form::close() !!}

</div>
<div class="table-responsive">
  {!! Form::open(array('route' => 'role.permission', 'method'=>'POST')) !!}
  <table class="table table-striped">
    <thead class="thead-light">
      <tr>
        <th scope="col">{{ __('Permission') }}</th>
        @foreach ($role_header as $role_name)
        <th scope="col">{{ $role_name }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @if (empty($permissions))
      <tr>
        <td colspan="{{ count($role_header) + 1 }}"><strong>{{ __('There is no permission') }}</strong></td>
      </tr>
      @endif

      @foreach ($permissions as $group => $permiss)
      <tr><td colspan="{{ count($role_header) + 1 }}"><strong>{{ $group }}</strong></td></tr>
      @foreach ($permiss as $permission)
      <tr>
        <td scope="row" style="padding-left: 30px;">{{ $permission->name }}</td>
        @foreach ($role_header as $role_id => $role_name)
        <td scope="row">
          <div class="custom-control custom-checkbox">
            {!! Form::checkbox('rolepermission_' . $role_id . '_' . $permission->id, $role_id . '_' . $permission->id, $rolePermissions[$role_id . '_' . $permission->id], ['class' => 'custom-control-input', 'id' => 'check' . $role_id . $permission->id]) !!}
            <label class="custom-control-label" for="{{ 'check' .  $role_id . $permission->id }}"></label>
          </div>
        </td>
        @endforeach
      </tr>
      @endforeach
      @endforeach
    </tbody>
  </table>
  <div class="py-3">
    <button type="submit" class="btn btn-primary">{{ __('Save permissions') }}</button>
  </div>
  {!! Form::close() !!}
</div>
@endsection
