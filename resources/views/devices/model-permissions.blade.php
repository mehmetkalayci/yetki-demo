@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cihaz Model İzinleri: {{ $device->name }}</h5>
                    <span class="badge bg-secondary">{{ $device->hospital->name }}</span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kullanıcı</th>
                                <th>İzin</th>
                                <th>Başlangıç</th>
                                <th>Bitiş</th>
                                <th>Kısıtlı</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($device->modelPermissions as $modelPermission)
                            <tr>
                                <td>{{ $modelPermission->user->name }}</td>
                                <td>{{ $modelPermission->permission->display_name }}</td>
                                <td>
                                    @if($modelPermission->start_date)
                                        {{ $modelPermission->start_date->format('d.m.Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($modelPermission->end_date)
                                        <span class="badge {{ $modelPermission->end_date->isPast() ? 'bg-danger' : 'bg-success' }}">
                                            {{ $modelPermission->end_date->format('d.m.Y') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($modelPermission->is_restricted)
                                        <span class="badge bg-warning">Evet</span>
                                    @else
                                        <span class="badge bg-success">Hayır</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('devices.model-permissions.revoke', $device) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="permission_id" value="{{ $modelPermission->id }}">
                                        <button class="btn btn-sm btn-danger">Kaldır</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>

                    <h6>Yeni Model İzni Ekle</h6>
                    <form action="{{ route('devices.model-permissions.assign', $device) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Kullanıcı</label>
                                    <select name="user_id" class="form-select" required>
                                        <option value="">Seçiniz</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Model ID'leri</label>
                                    <input type="text" name="model_ids" class="form-control" placeholder="Model ID'lerini virgülle ayırarak girin" required>
                                    <small class="form-text text-muted">Örneğin: 1,2,3</small>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">İzin Ekle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
