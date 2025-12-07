@extends('admin.layouts.app')

@section('page_title', 'Tạo Rule mới')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.rules.index') }}">Danh sách Rules</a></li>
    <li class="breadcrumb-item active">Tạo mới</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Thông tin cơ bản</h3>
                </div>
                <form action="{{ route('admin.rules.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Mã Rule (Unique Code) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="VD: MENH_VO_CHINH_DIEU">
                                    @error('code')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Mã duy nhất để định danh rule.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority">Độ ưu tiên</label>
                                    <input type="number" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" value="{{ old('priority', 100) }}">
                                    @error('priority')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Số càng lớn độ ưu tiên càng cao.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="scope">Phạm vi (Scope)</label>
                                    <select class="form-control @error('scope') is-invalid @enderror" id="scope" name="scope">
                                        <option value="house" {{ old('scope') == 'house' ? 'selected' : '' }}>House (Theo Cung)</option>
                                        <option value="global" {{ old('scope') == 'global' ? 'selected' : '' }}>Global (Toàn cục)</option>
                                        <option value="period" {{ old('scope') == 'period' ? 'selected' : '' }}>Period (Vận hạn)</option>
                                    </select>
                                    @error('scope')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="target_house">Cung áp dụng (Nếu Scope = House)</label>
                                    <select class="form-control @error('target_house') is-invalid @enderror" id="target_house" name="target_house">
                                        <option value="">-- Không chọn (hoặc chọn sau) --</option>
                                        <option value="MENH" {{ old('target_house') == 'MENH' ? 'selected' : '' }}>Mệnh</option>
                                        <option value="PHU_MAU" {{ old('target_house') == 'PHU_MAU' ? 'selected' : '' }}>Phụ Mẫu</option>
                                        <option value="PHUC_DUC" {{ old('target_house') == 'PHUC_DUC' ? 'selected' : '' }}>Phúc Đức</option>
                                        <option value="DIEN_TRACH" {{ old('target_house') == 'DIEN_TRACH' ? 'selected' : '' }}>Điền Trạch</option>
                                        <option value="QUAN_LOC" {{ old('target_house') == 'QUAN_LOC' ? 'selected' : '' }}>Quan Lộc</option>
                                        <option value="NO_BOC" {{ old('target_house') == 'NO_BOC' ? 'selected' : '' }}>Nô Bộc</option>
                                        <option value="THIEN_DI" {{ old('target_house') == 'THIEN_DI' ? 'selected' : '' }}>Thiên Di</option>
                                        <option value="TAT_ACH" {{ old('target_house') == 'TAT_ACH' ? 'selected' : '' }}>Tật Ách</option>
                                        <option value="TAI_BACH" {{ old('target_house') == 'TAI_BACH' ? 'selected' : '' }}>Tài Bạch</option>
                                        <option value="TU_TUC" {{ old('target_house') == 'TU_TUC' ? 'selected' : '' }}>Tử Tức</option>
                                        <option value="PHU_THE" {{ old('target_house') == 'PHU_THE' ? 'selected' : '' }}>Phu Thê</option>
                                        <option value="HUYNH_DE" {{ old('target_house') == 'HUYNH_DE' ? 'selected' : '' }}>Huynh Đệ</option>
                                        {{-- Thêm Thân cư... nếu cần --}}
                                    </select>
                                    @error('target_house')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="text_template">Nội dung luận giải (Template) <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('text_template') is-invalid @enderror" id="text_template" name="text_template" rows="5" placeholder="Nhập nội dung luận giải...">{{ old('text_template') }}</textarea>
                            @error('text_template')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label for="is_active" class="custom-control-label">Kích hoạt</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Tạo Rule & Tiếp tục thêm Điều kiện</button>
                        <a href="{{ route('admin.rules.index') }}" class="btn btn-default ml-2">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
