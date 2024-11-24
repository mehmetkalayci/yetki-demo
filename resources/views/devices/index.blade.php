@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cihazlar</h5>
                    @if(auth()->user()->hasPermission('cihaz-ekle'))
                        <a href="{{ route('devices.create') }}" class="btn btn-primary">Yeni Cihaz</a>
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
                                <th>Hastane</th>
                                <th>Cihaz Adı</th>
                                <th>Seri No</th>
                                <th>Model</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $device)
                            <tr>
                                <td>{{ $device->id }}</td>
                                <td>{{ $device->hospital->name }}</td>
                                <td>{{ $device->name }}</td>
                                <td>{{ $device->serial_number }}</td>
                                <td>{{ $device->model }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if(auth()->user()->hasPermission('cihaz-düzenle'))
                                            <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-warning">Düzenle</a>
                                        @endif
                                        
                                        @if(auth()->user()->hasPermission('cihaz-sil') || 
                                            auth()->user()->hasModelPermission($device, 'cihaz-sil') ||
                                            auth()->user()->hasModelPermission($device->hospital, 'cihaz-sil'))
                                            <form action="{{ route('devices.destroy', $device) }}" 
                                                  method="POST"
                                                  onsubmit="return confirm('Bu cihazı silmek istediğinizden emin misiniz?')">
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
