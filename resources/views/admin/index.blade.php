@extends('admin.layouts.app')

@section('page_title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    {{-- Info boxes --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Thành viên</span>
                    <span class="info-box-number">
                        {{ $users_count }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-star"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Sao (Stars)</span>
                    <span class="info-box-number">{{ $stars_count }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-scroll"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Lá số đã lập</span>
                    <span class="info-box-number">{{ $horoscopes_count }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Luật giải (Rules)</span>
                    <span class="info-box-number">{{ $rules_count }}</span>
                </div>
            </div>
        </div>
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Chào mừng đến với TuVi Engine CMS</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <p>Hệ thống quản lý dữ liệu Tử Vi chuyên sâu.</p>
                    <ul>
                        <li>Quản lý thông tin 100+ Sao tử vi.</li>
                        <li>Cấu hình các luật giải đoán (Rules).</li>
                        <li>Xem và quản lý danh sách lá số người dùng.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection