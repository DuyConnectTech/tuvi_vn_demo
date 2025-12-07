@extends('admin.layouts.app')

@section('page_title', 'Quản lý Luật giải (Rules)')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Danh sách Rules</li>
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
                    <h3 class="card-title">Danh sách Rules</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.rules.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Thêm Rule mới
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mã Rule (Code)</th>
                                <th>Phạm vi (Scope)</th>
                                <th>Cung áp dụng</th>
                                <th>Độ ưu tiên</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rules as $rule)
                                <tr>
                                    <td>{{ $rule->id }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $rule->code }}</span>
                                    </td>
                                    <td>
                                        @if($rule->scope == 'house')
                                            <span class="badge badge-info">Theo Cung</span>
                                        @elseif($rule->scope == 'global')
                                            <span class="badge badge-success">Toàn cục</span>
                                        @else
                                            <span class="badge badge-warning">{{ $rule->scope }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $rule->target_house ?? '-' }}</td>
                                    <td>{{ $rule->priority }}</td>
                                    <td>
                                        @if($rule->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.rules.edit', $rule) }}" class="btn btn-info btn-xs" title="Sửa">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.rules.destroy', $rule) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa rule này không?');">
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
                                    <td colspan="7" class="text-center">Chưa có rule nào được thiết lập.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $rules->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
