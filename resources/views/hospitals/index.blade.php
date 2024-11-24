@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hastaneler</h5>
                    @if(auth()->user()->hasPermission('hastane-ekle'))
                        <a href="{{ route('hospitals.create') }}" class="btn btn-primary">Yeni Hastane</a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hastane Adı</th>
                                <th>Telefon</th>
                                <th>E-posta</th>
                                <th>Cihaz Sayısı</th>
                                <th>Özel İzinler</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hospitals as $hospital)
                            <tr>
                                <td>{{ $hospital->id }}</td>
                                <td>{{ $hospital->name }}</td>
                                <td>{{ $hospital->phone }}</td>
                                <td>{{ $hospital->email }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $hospital->devices_count }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $hospital->model_permissions_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @if(auth()->user()->hasPermission('hastane-düzenle') || 
                                            auth()->user()->hasModelPermission($hospital, 'hastane-düzenle'))
                                            <a href="{{ route('hospitals.edit', $hospital) }}" 
                                               class="btn btn-sm btn-warning">Düzenle</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('hastane-sil') || 
                                            auth()->user()->hasModelPermission($hospital, 'hastane-sil'))
                                            <form action="{{ route('hospitals.destroy', $hospital) }}" 
                                                  method="POST"
                                                  onsubmit="return confirm('Bu hastaneyi silmek istediğinize emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                            </form>
                                        @endif
                                    </div>
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
