@extends('client.layouts.app')

@section('title', 'Lập Lá Số Tử Vi Trực Tuyến - TuVi Engine')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg mt-4">
                <div class="card-header bg-danger text-white text-center py-4">
                    <h2 class="font-weight-bold mb-0">LẬP LÁ SỐ TỬ VI</h2>
                    <p class="mb-0 small">Nhập chính xác giờ sinh theo dương lịch để có kết quả chuẩn nhất</p>
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
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', 'Tâm Như Lâm') }}" placeholder="Nhập họ tên" required>
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

                        <h5 class="text-secondary mt-4 border-bottom pb-2">Thông tin Ngày Sinh (Dương Lịch)</h5>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Ngày</label>
                                <select class="form-control" name="day">
                                    @for($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ old('day', 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Tháng</label>
                                <select class="form-control" name="month">
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('month', 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Năm</label>
                                <select class="form-control" name="year">
                                    @for($i = 1950; $i <= 2030; $i++)
                                        <option value="{{ $i }}" {{ old('year', 2000) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Giờ sinh (0h - 23h)</label>
                                <select class="form-control" name="hour">
                                    @for($i = 0; $i <= 23; $i++)
                                        <option value="{{ $i }}" {{ old('hour', 12) == $i ? 'selected' : '' }}>{{ $i }} giờ</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Phút sinh</label>
                                <select class="form-control" name="minute">
                                    @for($i = 0; $i <= 59; $i++)
                                        <option value="{{ $i }}" {{ old('minute', 30) == $i ? 'selected' : '' }}>{{ $i }} phút</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <h5 class="text-secondary mt-4 border-bottom pb-2">Thông tin Xem Hạn</h5>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Năm xem</label>
                                <select class="form-control" name="view_year">
                                    @for($y = date('Y') - 10; $y <= date('Y') + 10; $y++)
                                        <option value="{{ $y }}" {{ old('view_year', 2025) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Tháng xem (Âm lịch)</label>
                                <select class="form-control" name="view_month">
                                    <option value="">-- Cả năm --</option>
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ old('view_month') == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                                    @endfor
                                </select>
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
            </div>

            {{-- History Section (LocalStorage) --}}
            <div class="card mt-4 border-0 shadow-sm" id="history-card" style="display: none;">
                <div class="card-header bg-white font-weight-bold">
                    <i class="fas fa-history mr-2"></i> Lịch sử xem lá số
                </div>
                <ul class="list-group list-group-flush" id="history-list"></ul>
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
                loadHistory();
            });

            function loadHistory() {
                let history = JSON.parse(localStorage.getItem('tuvi_history')) || [];
                if (history.length > 0) {
                    $('#history-card').show();
                    let html = '';
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

        if (window.jQuery) { initApp(); } else {
            var checkInterval = setInterval(function() {
                if (window.jQuery) { clearInterval(checkInterval); initApp(); }
            }, 100);
        }
    })();
</script>
@endpush