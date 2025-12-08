@extends('client.layouts.app')

@section('title', 'Lập Lá Số Tử Vi Trực Tuyến - TuVi Engine')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg mt-4">
                <div class="card-header bg-danger text-white text-center py-4">
                    <h2 class="font-weight-bold mb-0">LẬP LÁ SỐ TỬ VI</h2>
                    <p class="mb-0 small">Luận giải chi tiết - Chính xác - Miễn phí</p>
                </div>
                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('client.horoscopes.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Họ và tên</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập họ tên đương số" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold d-block">Giới tính</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="gender_male" name="gender" class="custom-control-input" value="male" {{ old('gender', 'male') == 'male' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="gender_male">Nam</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="gender_female" name="gender" class="custom-control-input" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="gender_female">Nữ</label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="birth_date" class="font-weight-bold">Ngày sinh (Dương lịch)</label>
                                <input type="date" class="form-control form-control-lg" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birth_time" class="font-weight-bold">Giờ sinh</label>
                                <input type="time" class="form-control form-control-lg" id="birth_time" name="birth_time" value="{{ old('birth_time', '12:00') }}" required>
                            </div>
                        </div>

                        <input type="hidden" name="timezone" value="Asia/Ho_Chi_Minh">

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-danger btn-lg btn-block font-weight-bold py-3 shadow-sm">
                                <i class="fas fa-rocket mr-2"></i> LẬP LÁ SỐ NGAY
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center text-muted bg-light py-3">
                    <small>Hệ thống sử dụng lịch thiên văn chính xác. Hỗ trợ luận giải tự động bằng AI.</small>
                </div>
            </div>

            {{-- History Section (LocalStorage) --}}
            <div class="card mt-4 border-0 shadow-sm" id="history-card" style="display: none;">
                <div class="card-header bg-white font-weight-bold">
                    <i class="fas fa-history mr-2"></i> Lịch sử xem lá số
                </div>
                <ul class="list-group list-group-flush" id="history-list">
                    {{-- Items will be added by JS --}}
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    (function() {
        function initApp() {
            var $ = window.jQuery;
            
            $(document).ready(function() {
                // 1. Load History
                loadHistory();
            });

            function loadHistory() {
                let history = JSON.parse(localStorage.getItem('tuvi_history')) || [];
                if (history.length > 0) {
                    $('#history-card').show();
                    let html = '';
                    // Show last 5
                    history.slice(0, 5).forEach(item => {
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="/la-so/${item.slug}" class="text-dark font-weight-bold">${item.name}</a>
                                    <small class="text-muted">${item.date}</small>
                                </li>`;
                    });
                    $('#history-list').html(html);
                }
            }
        }

        if (window.jQuery) {
            initApp();
        } else {
            var checkInterval = setInterval(function() {
                if (window.jQuery) {
                    clearInterval(checkInterval);
                    initApp();
                }
            }, 100);
        }
    })();
</script>
@endpush
