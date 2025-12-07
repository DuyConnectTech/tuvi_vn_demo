@extends('admin.layouts.app')

@section('page_title', 'Cập nhật Sao')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.stars.index') }}">Danh sách Sao</a></li>
    <li class="breadcrumb-item active">Cập nhật</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa: {{ $star->name }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.stars.update', $star) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Tên Sao <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $star->name) }}" placeholder="Nhập tên sao" onkeyup="generateSlug()">
                                    @error('name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">Slug (URL) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $star->slug) }}" placeholder="tu-vi">
                                    @error('slug')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="group_type">Phân loại <span class="text-danger">*</span></label>
                                    <select class="form-control @error('group_type') is-invalid @enderror" id="group_type" name="group_type">
                                        <option value="chinh_tinh" {{ old('group_type', $star->group_type) == 'chinh_tinh' ? 'selected' : '' }}>Chính Tinh</option>
                                        <option value="phu_tinh" {{ old('group_type', $star->group_type) == 'phu_tinh' ? 'selected' : '' }}>Phụ Tinh</option>
                                        <option value="sat_tinh" {{ old('group_type', $star->group_type) == 'sat_tinh' ? 'selected' : '' }}>Sát Tinh</option>
                                        <option value="cat_tinh" {{ old('group_type', $star->group_type) == 'cat_tinh' ? 'selected' : '' }}>Cát Tinh</option>
                                        <option value="tu_hoa" {{ old('group_type', $star->group_type) == 'tu_hoa' ? 'selected' : '' }}>Tứ Hóa</option>
                                        <option value="khac" {{ old('group_type', $star->group_type) == 'khac' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                    @error('group_type')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="default_element">Ngũ hành</label>
                                    <select class="form-control @error('default_element') is-invalid @enderror" id="default_element" name="default_element">
                                        <option value="">-- Chọn --</option>
                                        <option value="Kim" {{ old('default_element', $star->default_element) == 'Kim' ? 'selected' : '' }}>Kim</option>
                                        <option value="Mộc" {{ old('default_element', $star->default_element) == 'Mộc' ? 'selected' : '' }}>Mộc</option>
                                        <option value="Thủy" {{ old('default_element', $star->default_element) == 'Thủy' ? 'selected' : '' }}>Thủy</option>
                                        <option value="Hỏa" {{ old('default_element', $star->default_element) == 'Hỏa' ? 'selected' : '' }}>Hỏa</option>
                                        <option value="Thổ" {{ old('default_element', $star->default_element) == 'Thổ' ? 'selected' : '' }}>Thổ</option>
                                    </select>
                                    @error('default_element')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quality">Đặc tính / Phẩm chất</label>
                                    <input type="text" class="form-control @error('quality') is-invalid @enderror" id="quality" name="quality" value="{{ old('quality', $star->quality) }}" placeholder="VD: Nam Đẩu Tinh">
                                    @error('quality')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_main" name="is_main" value="1" {{ old('is_main', $star->is_main) ? 'checked' : '' }}>
                                <label for="is_main" class="custom-control-label">Là Chính Tinh quan trọng</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả chi tiết</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả...">{{ old('description', $star->description) }}</textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                        <a href="{{ route('admin.stars.index') }}" class="btn btn-default ml-2">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function generateSlug() {
        let title = document.getElementById('name').value;
        let slug = title.toLowerCase();
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/\`|~|!|@|#|\||$|%|^|&|*()|+|,|.|/|?|>|<|'|"|:|;|_/gi, '');
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/----/gi, '-');
        slug = slug.replace(/---/gi, '-');
        slug = slug.replace(/--/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/@-|-@|@/gi, '');
        document.getElementById('slug').value = slug;
    }
</script>
@endpush
