@extends('admin.layouts.app')

@section('page_title', 'Quản lý Tags')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tags</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Thêm Tag mới</h3></div>
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên Tag</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Slug (Optional)</label>
                            <input type="text" class="form-control" name="slug">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách Tags</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Slug</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->slug }}</td>
                                    <td>
                                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xóa?');">
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
                    {{ $tags->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
