@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Yeni Rol Oluştur</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Rol Adı</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="örnek-rol-adi">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Sadece küçük harf, rakam ve tire (-) kullanabilirsiniz.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">İzinler</label>
                            <div class="row">
                                @foreach($permissions->groupBy('group.name') as $groupName => $groupPermissions)
                                    <div class="col-md-4 mb-3">
                                        <h6>{{ $groupName }}</h6>
                                        @foreach($groupPermissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}"
                                                       class="form-check-input"
                                                       {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $permission->display_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">İptal</a>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
