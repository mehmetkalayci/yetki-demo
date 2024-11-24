@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Model Bazlı İzinler: {{ $user->name }}</h5>
                </div>
                <div class="card-body">
                    <h6>Mevcut Model İzinleri</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Model</th>
                                <th>Model ID</th>
                                <th>İzin</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->modelPermissions as $modelPermission)
                            <tr>
                                <td>{{ $modelPermission->model_type }}</td>
                                <td>{{ $modelPermission->model_id }}</td>
                                <td>{{ $modelPermission->permission->name }}</td>
                                <td>
                                    <form action="{{ route('users.model-permissions.revoke', [$user, $modelPermission]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Kaldır</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <h6>Yeni Model İzni Ekle</h6>
                    <form action="{{ route('users.model-permissions.assign', $user) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Model Türü</label>
                                    <input type="text" name="model_type" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Model ID</label>
                                    <input type="number" name="model_id" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">İzin</label>
                                    <select name="permission_id" class="form-select" required>
                                        <option value="">Seçiniz</option>
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Model İzni Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
