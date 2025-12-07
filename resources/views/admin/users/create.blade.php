@extends('admin.layouts.app')

@section('page_title', 'Thêm Thành viên mới')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Thành viên</a></li>
    <li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Thông tin</h3></div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Xác nhận Mật khẩu</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default ml-2">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
