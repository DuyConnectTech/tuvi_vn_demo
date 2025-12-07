@extends('admin.layouts.app')

@section('page_title', 'Tạo Lá số mới')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.horoscopes.index') }}">Danh sách Lá số</a></li>
    <li class="breadcrumb-item active">Tạo mới</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Thông tin Đương số</h3>
                </div>
                <form action="{{ route('admin.horoscopes.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập họ tên">
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender">Giới tính <span class="text-danger">*</span></label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            @error('gender')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birth_date">Ngày sinh (Dương lịch) <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birth_time">Giờ sinh <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('birth_time') is-invalid @enderror" id="birth_time" name="birth_time" value="{{ old('birth_time') }}">
                                    @error('birth_time')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="timezone">Múi giờ</label>
                            <input type="text" class="form-control" id="timezone" name="timezone" value="Asia/Ho_Chi_Minh" readonly>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Tạo & Tiếp tục an sao</button>
                        <a href="{{ route('admin.horoscopes.index') }}" class="btn btn-default ml-2">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
