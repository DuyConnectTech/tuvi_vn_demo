@extends('client.layouts.app')

@section('title', 'Lá Số Của Tôi - TuVi Engine')

@section('content')
<div class="container">
    <h2 class="mb-4">Lá Số Của Tôi</h2>

    @if($horoscopes->isEmpty())
        <div class="alert alert-info">
            Bạn chưa lưu lá số nào. <a href="{{ route('home') }}">Lập lá số ngay</a>.
        </div>
    @else
        <div class="row">
            @foreach($horoscopes as $item)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold">
                                <a href="{{ route('client.horoscopes.show', $item->slug) }}" class="text-decoration-none text-danger">
                                    {{ $item->name }}
                                </a>
                            </h5>
                            <p class="card-text text-muted mb-1">
                                <i class="fas fa-birthday-cake mr-1"></i> {{ $item->birth_gregorian->format('d/m/Y H:i') }}
                            </p>
                            <p class="card-text text-muted mb-1">
                                <i class="fas fa-venus-mars mr-1"></i> {{ $item->gender == 'male' ? 'Nam' : 'Nữ' }}
                            </p>
                            <p class="card-text small text-secondary">
                                {{ $item->can_chi_year }} - {{ $item->nap_am }} - {{ $item->cuc }}
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                            <small class="text-muted">Tạo: {{ $item->created_at->diffForHumans() }}</small>
                            <a href="{{ route('client.horoscopes.show', $item->slug) }}" class="btn btn-sm btn-outline-primary">Xem</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $horoscopes->links() }}
        </div>
    @endif
</div>
@endsection
