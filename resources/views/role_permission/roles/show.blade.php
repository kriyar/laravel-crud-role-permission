@extends('role_permission.main')

@section('title')
{{ __('Show Role') }}
@endsection

@section('content')
<div class="py-3">
  <h2>{{ __('Role detail') }}</h2>
</div>

<div class="card">
  <div class="card-header">
    {{ $role->name }}
  </div>
  <div class="card-body">
    <strong> {{ __('Permissions') }}:</strong>
    @if(!empty($rolePermissions))
        <ul>
        @foreach($rolePermissions as $v)
            <li>{{ $v->name }}</li>
        @endforeach
    @endif
    <p></p>
    <p>
      <a class="btn btn-primary" href="{{ route('roles.index') }}"> {{ __('Back') }}</a>
    </p>
  </div>
</div>

@endsection
