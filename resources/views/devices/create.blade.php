@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Yeni Cihaz</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('devices.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Hastane</label>
                            <select name="hospital_id" class="form-select @error('hospital_id') is-invalid @enderror">
                                <option value="">Seçiniz</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{ old('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cihaz Oluştur</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
