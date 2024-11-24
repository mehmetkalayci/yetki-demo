@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">İzin Düzenle: {{ $permission->display_name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">İzin Adı</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $permission->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Sadece küçük harf, rakam ve tire (-) kullanabilirsiniz.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Görünen Ad</label>
                            <input type="text" 
                                   name="display_name" 
                                   class="form-control @error('display_name') is-invalid @enderror"
                                   value="{{ old('display_name', $permission->display_name) }}">
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">İzin Grubu</label>
                            <select name="permission_group_id" 
                                    class="form-select @error('permission_group_id') is-invalid @enderror">
                                <option value="">Seçiniz</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" 
                                            {{ old('permission_group_id', $permission->permission_group_id) == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permission_group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">İptal</a>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
