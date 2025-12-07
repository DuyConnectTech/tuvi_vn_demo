@extends('admin.layouts.app')

@section('page_title', 'Cập nhật Thuật ngữ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.glossaries.index') }}">Thuật ngữ</a></li>
    <li class="breadcrumb-item active">Cập nhật</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Thông tin: {{ $glossary->term }}</h3></div>
                <form action="{{ route('admin.glossaries.update', $glossary) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Thuật ngữ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('term') is-invalid @enderror" name="term" value="{{ old('term', $glossary->term) }}">
                            @error('term') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Danh mục</label>
                            <input type="text" class="form-control" name="category" value="{{ old('category', $glossary->category) }}">
                        </div>
                        <div class="form-group">
                            <label>Định nghĩa / Nội dung</label>
                            <textarea class="form-control" name="definition" rows="3">{{ old('definition', $glossary->definition) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <textarea class="form-control" name="description" rows="2">{{ old('description', $glossary->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Link tham khảo</label>
                            <input type="url" class="form-control" name="reference_url" value="{{ old('reference_url', $glossary->reference_url) }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('admin.glossaries.index') }}" class="btn btn-default ml-2">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
