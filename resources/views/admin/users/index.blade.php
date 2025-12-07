@extends('admin.layouts.app')

@section('page_title', 'Quản lý Thành viên')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Danh sách Thành viên</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách Thành viên</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info btn-xs"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xóa user này?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
