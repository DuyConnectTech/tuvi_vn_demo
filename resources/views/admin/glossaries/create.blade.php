@extends('admin.layouts.app')

@section('page_title', 'Thêm Thuật ngữ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.glossaries.index') }}">Thuật ngữ</a></li>
    <li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Thông tin</h3></div>
                <form action="{{ route('admin.glossaries.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Thuật ngữ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('term') is-invalid @enderror" name="term" value="{{ old('term') }}">
                            @error('term') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Danh mục</label>
                            <input type="text" class="form-control" name="category" value="{{ old('category') }}" placeholder="VD: Cung, Sao...">
                        </div>
                        <div class="form-group">
                            <label>Định nghĩa / Nội dung</label>
                            <textarea class="form-control" id="definition_editor" name="definition" rows="3">{{ old('definition') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <textarea class="form-control" id="description_editor" name="description" rows="2">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Link tham khảo</label>
                            <input type="url" class="form-control" name="reference_url" value="{{ old('reference_url') }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                        <a href="{{ route('admin.glossaries.index') }}" class="btn btn-default ml-2">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#definition_editor').summernote({
            height: 150,
            minHeight: null,
            maxHeight: null,
            focus: true
        });
        $('#description_editor').summernote({
            height: 100,
            minHeight: null,
            maxHeight: null,
            focus: false
        });
    });
</script>
@endpush
