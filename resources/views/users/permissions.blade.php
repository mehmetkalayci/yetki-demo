@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Kullanıcı İzinleri: {{ $user->name }}</h5>
                </div>
                <div class="card-body">
                    <h6>Mevcut İzinler</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>İzin</th>
                                <th>Kısıtlı</th>
                                <th>Başlangıç</th>
                                <th>Bitiş</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userPermissions as $permission)
                            <tr>
                                <td>{{ $permission->display_name }}</td>
                                <td>
                                    @if($permission->pivot->is_restricted)
                                        <span class="badge bg-danger">Evet</span>
                                    @else
                                        <span class="badge bg-success">Hayır</span>
                                    @endif
                                </td>
                                <td>{{ $permission->pivot->start_date }}</td>
                                <td>{{ $permission->pivot->end_date }}</td>
                                <td>
                                    <form action="{{ route('users.permissions.revoke', $user) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="permission_id" value="{{ $permission->id }}">
                                        <button class="btn btn-sm btn-danger">Kaldır</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>

                    <h6>Yeni İzin Ekle</h6>
                    <form action="{{ route('users.permissions.assign', $user) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">İzin</label>
                                    <select name="permission_id" class="form-select" required>
                                        <option value="">Seçiniz</option>
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->id }}">
                                                {{ $permission->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Kısıtlı</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               name="is_restricted" 
                                               value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Başlangıç Tarihi</label>
                                    <input type="date" 
                                           class="form-control" 
                                           name="start_date">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Bitiş Tarihi</label>
                                    <input type="date" 
                                           class="form-control" 
                                           name="end_date">
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">İzin Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
