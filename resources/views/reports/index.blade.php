@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Raporlar</h5>
                    @if(auth()->user()->hasPermission('rapor-ekle'))
                        <a href="{{ route('reports.create') }}" class="btn btn-primary">Yeni Rapor</a>
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
                                <th>Rapor Adı</th>
                                <th>Tarih</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if(auth()->user()->hasPermission('rapor-düzenle'))
                                            <a href="{{ route('reports.edit', $report) }}" class="btn btn-sm btn-warning">Düzenle</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('rapor-sil'))
                                            <form action="{{ route('reports.destroy', $report) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Sil</button>
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