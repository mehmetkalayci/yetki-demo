@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Kullanıcı Rolleri: {{ $user->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.roles.assign', $user) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            @foreach($roles as $role)
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       name="roles[]" 
                                       value="{{ $role->id }}" 
                                       id="role_{{ $role->id }}"
                                       @checked(in_array($role->id, $userRoles))
                                       @disabled($role->name === 'süper-admin' && !auth()->user()->hasRole('süper-admin'))>
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->name }}
                                    @if($role->name === 'süper-admin')
                                        <span class="badge bg-danger">Dikkat</span>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Rolleri Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
