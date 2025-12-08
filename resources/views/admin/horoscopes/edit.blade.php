@extends('admin.layouts.app')

@section('page_title', 'Cập nhật Lá số & An Sao')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.horoscopes.index') }}">Danh sách Lá số</a></li>
    <li class="breadcrumb-item active">Cập nhật</li>
@endsection

@section('content')
    <div class="row">
        {{-- Info Column --}}
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Thông tin Đương số</h3>
                </div>
                <form action="{{ route('admin.horoscopes.update', $horoscope) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $horoscope->name) }}">
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <select class="form-control" name="gender">
                                <option value="male" {{ $horoscope->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                <option value="female" {{ $horoscope->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input type="date" class="form-control" name="birth_date" value="{{ $horoscope->birth_gregorian->format('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label>Giờ sinh</label>
                            <input type="time" class="form-control" name="birth_time" value="{{ $horoscope->birth_gregorian->format('H:i') }}">
                        </div>

                        <div class="form-group">
                            <label>Ghi chú / Mô tả</label>
                            <textarea class="form-control" id="description_editor" name="description" rows="3">{{ old('description', $horoscope->description) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Tags</label>
                            <select class="form-control select2-tags" name="tags[]" multiple="multiple">
                                @foreach($allTags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $horoscope->tags->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_public" name="is_public" value="1" {{ $horoscope->is_public ? 'checked' : '' }}>
                                <label for="is_public" class="custom-control-label">Công khai</label>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('client.horoscopes.show', $horoscope->slug) }}" target="_blank" class="btn btn-info btn-block">
                                <i class="fas fa-eye"></i> Xem Lá Số trên Client
                            </a>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-2">Cập nhật thông tin</button>
                    </div>
                </form>
            </div>

            {{-- Meta Info (Can Chi, Cuc...) --}}
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Thông tin Tử Vi (Manual)</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Nhập tay các thông số này để test Rule Engine.</p>
                    {{-- Form update meta here if needed --}}
                    <div class="form-group">
                        <label>Can Chi Năm</label>
                        <input type="text" class="form-control form-control-sm" value="{{ $horoscope->can_chi_year }}" placeholder="VD: Giáp Tý">
                    </div>
                     <div class="form-group">
                        <label>Cục</label>
                        <input type="text" class="form-control form-control-sm" value="{{ $horoscope->cuc }}" placeholder="VD: Thủy Nhị Cục">
                    </div>
                </div>
            </div>
        </div>

        {{-- Houses & Stars Column --}}
        <div class="col-md-8">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Thiết lập 12 Cung & Sao (Thủ công)</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($horoscope->houses->sortBy('house_order') as $house)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 shadow-sm border">
                                    <div class="card-header bg-light p-2">
                                        <strong>{{ $house->label }}</strong> ({{ $house->code }})
                                        <span class="float-right badge badge-secondary">{{ $house->branch }}</span>
                                    </div>
                                    <div class="card-body p-2" style="min-height: 150px;">
                                        <ul class="list-unstyled mb-2" id="stars-list-{{ $house->id }}">
                                            @foreach($house->stars as $star)
                                                <li class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                                    <span class="{{ $star->is_main ? 'font-weight-bold text-danger' : '' }}">
                                                        {{ $star->name }}
                                                    </span>
                                                    <small class="text-muted">{{ $star->pivot->status }}</small>
                                                    {{-- Delete btn (mockup) --}}
                                                    <a href="{{ route('admin.horoscope-houses.stars.destroy', [$house->id, $star->id]) }}" class="text-danger ml-1 remove-star-btn"><i class="fas fa-times"></i></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        
                                        {{-- Add Star Form (Inline) --}}
                                        <div class="input-group input-group-sm mt-2">
                                            <select class="custom-select" id="star-select-{{ $house->id }}">
                                                <option value="">+ Thêm sao...</option>
                                                @foreach($allStars as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-success btn-add-star" type="button" data-house-id="{{ $house->id }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Init Select2
        $('.select2-tags').select2({
            theme: 'bootstrap4',
            placeholder: "Chọn tags",
            allowClear: true
        });

        // Init Summernote
        $('#description_editor').summernote({
            height: 150,
            minHeight: null,
            maxHeight: null,
            focus: false
        });

        // Existing logic for adding stars to house
        $('.btn-add-star').click(function() {
            let houseId = $(this).data('house-id');
            let starId = $(`#star-select-${houseId}`).val();
            
            if (!starId) {
                alert('Vui lòng chọn sao.');
                return;
            }

            let url = "{{ route('admin.horoscope-houses.stars.store', ':houseId') }}";
            url = url.replace(':houseId', houseId);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    star_id: starId
                },
                success: function(response) {
                    // alert(response.message);
                    location.reload(); // Reload to update UI
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.message || 'Có lỗi xảy ra.');
                }
            });
        });

        // Remove Star (Delegated event not strictly needed if simple link, but let's handle click)
        $('.remove-star-btn').click(function(e) {
            e.preventDefault();
            if(!confirm('Bạn muốn xóa sao này khỏi cung?')) return;

            let url = $(this).attr('href');
            
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra khi xóa sao.');
                }
            });
        });
    });
</script>
@endpush
