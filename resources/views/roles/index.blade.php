@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Roller</h5>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">Yeni Rol</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Rol Adı</th>
                                <th>Kullanıcı Sayısı</th>
                                <th>İzinler</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->users_count }}</td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                        <span class="badge bg-info me-1">
                                            {{ $permission->display_name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($role->name !== 'süper-admin')
                                        <div class="btn-group">
                                            <a href="{{ route('roles.edit', $role) }}" 
                                               class="btn btn-sm btn-warning">Düzenle</a>
                                            <form action="{{ route('roles.destroy', $role) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Bu rolü silmek istediğinize emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
