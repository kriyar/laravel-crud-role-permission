@extends('role_permission.main')

@section('title')
{{ __('Create Role') }}
@endsection

@section('content')
<div class="py-3">
  <h2>{{ __('Create new role') }}</h2>
  <p>
    <a class="btn btn-primary" href="{{ route('roles.index') }}">{{ __('Back to role list') }}</a>
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

{!! Form::open(array('route' => 'roles.store', 'method'=>'POST')) !!}
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-3">
    <div class="form-group">
      <strong>{{ __('Name') }}:</strong>
      {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control', 'required' => true, 'autofocus' => 'true']) !!}
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-3">
    <div class="form-group">
      <strong>{{ __('Guard name') }}:</strong>
      {!! Form::select('guard_name', $guard_name, null, ['class' => 'form-control']); !!}
    </div>
  </div>
  <div class="col-sm-12">
    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
  </div>
</div>
{!! Form::close() !!}

@endsection
