@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Profil Bilgileri</h5>
                </div>
                <div class="card-body">
                    <h6>Ad: {{ $user->name }}</h6>
                    <h6>Email: {{ $user->email }}</h6>
                    <h6>Roller:</h6>
                    <ul>
                        @foreach($user->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </ul>
                    <h6>İzinler:</h6>
                    <ul>
                        @foreach($user->permissions as $permission)
                            <li>{{ $permission->display_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
