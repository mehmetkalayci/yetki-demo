@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Yeni Rapor Oluştur</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Rapor Adı</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Rapor Oluştur</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection