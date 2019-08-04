@extends('role_permission.main')

@section('title')
{{ __('Show Permission') }}
@endsection

@section('content')
<div class="py-3">
  <h2>{{ __('Permission detail') }}</h2>
</div>

<div class="card">
  <div class="card-header">
    {{ $permission->name }}
  </div>
  <div class="card-body">
    <p>
      <strong> {{ __('Guard name') }}: </strong>
      {{ $permission->guard_name }}
    </p>

    <p>
      <strong> {{ __('Group') }}: </strong>
      {{ $permission->group }}
    </p>

    <strong> {{ __('Roles') }}:</strong>
    @if(!empty($rolePermissions))
        <ul>
        @foreach($rolePermissions as $v)
            <li>{{ $v->name }}</li>
        @endforeach
    @endif
    <p></p>
    <p>
      <a class="btn btn-primary" href="{{ route('permissions.index') }}"> {{ __('Back') }}</a>
    </p>
  </div>
</div>

@endsection
