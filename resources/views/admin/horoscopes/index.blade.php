@extends('admin.layouts.app')

@section('page_title', 'Quản lý Lá số')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Danh sách Lá số</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách Lá số</h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.horoscopes.index') }}" method="GET" class="d-inline-block mr-2">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="Tìm kiếm..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <a href="{{ route('admin.horoscopes.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tạo Lá số mới
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Người tạo</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh (DL)</th>
                                <th>Năm xem</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($horoscopes as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $item->name }}</span>
                                        <br>
                                        <small class="text-muted">{{ $item->slug }}</small>
                                    </td>
                                    <td>
                                        @if($item->user)
                                            <a href="{{ route('admin.users.edit', $item->user) }}">{{ $item->user->name }}</a>
                                        @else
                                            <span class="text-muted">Guest</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->gender == 'male' ? 'Nam' : 'Nữ' }}</td>
                                    <td>{{ $item->birth_gregorian->format('d/m/Y H:i') }}</td>
                                    <td>{{ $item->view_year }}</td>
                                    <td>
                                        <a href="{{ route('admin.horoscopes.edit', $item) }}" class="btn btn-info btn-xs" title="Sửa & An Sao">
                                            <i class="fas fa-pencil-alt"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.horoscopes.destroy', $item) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xóa lá số này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có lá số nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $horoscopes->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
