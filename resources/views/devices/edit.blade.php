@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cihaz Düzenle: {{ $device->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('devices.update', $device) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Hastane</label>
                            <select name="hospital_id" class="form-select @error('hospital_id') is-invalid @enderror">
                                <option value="">Seçiniz</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" 
                                        {{ old('hospital_id', $device->hospital_id) == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hospital_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cihaz Adı</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $device->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Seri No</label>
                            <input type="text" name="serial_number" 
                                   class="form-control @error('serial_number') is-invalid @enderror" 
                                   value="{{ old('serial_number', $device->serial_number) }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" 
                                   class="form-control @error('model') is-invalid @enderror" 
                                   value="{{ old('model', $device->model) }}">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Marka</label>
                            <input type="text" name="brand" 
                                   class="form-control @error('brand') is-invalid @enderror" 
                                   value="{{ old('brand', $device->brand) }}">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alım Tarihi</label>
                            <input type="date" name="purchase_date" 
                                   class="form-control" 
                                   value="{{ old('purchase_date', optional($device->purchase_date)->format('Y-m-d')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Garanti Bitiş Tarihi</label>
                            <input type="date" name="warranty_end" 
                                   class="form-control" 
                                   value="{{ old('warranty_end', optional($device->warranty_end)->format('Y-m-d')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notlar</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $device->notes) }}</textarea>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('devices.index') }}" class="btn btn-secondary">İptal</a>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
