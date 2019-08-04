@extends('role_permission.main')

@section('title')
{{ __('Manage user role') }}
@endsection

@section('content')
<div class="py-3">
  <h2>{{ __('Manage user role') }}</h2>
  <p>
    <a class="btn btn-primary" href="{{ route('user.list') }}">{{ __('Back to user list') }}</a>
  </p>
</div>

@if (count($errors) > 0)
<div class="alert alert-danger">
  <strong>Whoops!</strong> {{ __('There were some problems with your input.') }}<br><br>
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

{!! Form::open(['route' => ['user.role', $user->id], 'method'=>'POST']) !!}
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <strong>{{ __('Select following role to assign to user') }}:</strong>
    @foreach ($role_options as $guard_name => $roles)
      <div class="py-3">
        <strong>{{ $guard_name }}:</strong>
        @foreach ($roles as $role)
        <div class="custom-control custom-checkbox">
          {!! Form::checkbox('roles[]', $role->id, $userRoles[$role->id], ['class' => 'custom-control-input', 'id' => 'check' . $role->id]) !!}
          <label class="custom-control-label" for="{{ 'check' .  $role->id }}">{{ $role->name }}</label>
        </div>
      </div>
      @endforeach
    @endforeach
  </div>
  <div class="py-3 col-sm-12">
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
  </div>
</div>
{!! Form::close() !!}

@endsection
