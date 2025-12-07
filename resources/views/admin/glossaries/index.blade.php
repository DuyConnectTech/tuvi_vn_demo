@extends('admin.layouts.app')

@section('page_title', 'Quản lý Thuật ngữ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Thuật ngữ</li>
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
                    <h3 class="card-title">Danh sách Thuật ngữ</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.glossaries.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Thuật ngữ</th>
                                <th>Danh mục</th>
                                <th>Mô tả ngắn</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($glossaries as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <strong>{{ $item->term }}</strong><br>
                                        <small class="text-muted">{{ $item->slug }}</small>
                                    </td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->description, 50) }}</td>
                                    <td>
                                        <a href="{{ route('admin.glossaries.edit', $item) }}" class="btn btn-info btn-xs"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.glossaries.destroy', $item) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xóa?');">
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
                    {{ $glossaries->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
