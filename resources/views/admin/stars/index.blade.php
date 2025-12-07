@extends('admin.layouts.app')

@section('page_title', 'Quản lý Sao')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Danh sách Sao</li>
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
                    <h3 class="card-title">Danh sách Sao Tử Vi</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.stars.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Thêm Sao mới
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Sao</th>
                                <th>Slug</th>
                                <th>Loại</th>
                                <th>Ngũ hành</th>
                                <th>Đặc tính</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stars as $star)
                                <tr>
                                    <td>{{ $star->id }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $star->name }}</span>
                                        @if($star->is_main)
                                            <span class="badge badge-warning ml-1">Chính tinh</span>
                                        @endif
                                    </td>
                                    <td>{{ $star->slug }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $star->group_type)) }}</td>
                                    <td>{{ $star->default_element }}</td>
                                    <td>{{ $star->quality }}</td>
                                    <td>
                                        <a href="{{ route('admin.stars.edit', $star) }}" class="btn btn-info btn-xs" title="Sửa">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.stars.destroy', $star) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sao này không?');">
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
                                    <td colspan="7" class="text-center">Chưa có dữ liệu sao nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $stars->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
