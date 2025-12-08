@extends('client.layouts.app')

@section('title', 'Lá Số Tử Vi - ' . $horoscope->name)

@push('css')
    <style type="text/css">
        /* Ảnh đường kẻ cung chiếu (từ tuvi.vn) */
        .list-line-0 { background-image: url("{{ asset('storage/images/cung-chieu-03.png') }}"); }
        .list-line-1 { background-image: url("{{ asset('storage/images/cung-chieu-03.png') }}"); -webkit-transform: scaleX(-1); transform: scaleX(-1); }
        .list-line-2 { background-image: url("{{ asset('storage/images/cung-chieu-02.png') }}"); -webkit-transform: scaleX(-1); transform: scaleX(-1); }
        .list-line-3 { background-image: url("{{ asset('storage/images/cung-chieu-01.png') }}"); -webkit-transform: scaleX(-1); transform: scaleX(-1); }
        .list-line-4 { background-image: url("{{ asset('storage/images/cung-chieu-01.png') }}"); transform: rotate(180deg); }
        .list-line-5 { background-image: url("{{ asset('storage/images/cung-chieu-02.png') }}"); transform: rotate(180deg); }
        .list-line-6 { background-image: url("{{ asset('storage/images/cung-chieu-03.png') }}"); transform: rotate(180deg); }
        .list-line-7 { background-image: url("{{ asset('storage/images/cung-chieu-03.png') }}"); -webkit-transform: scaleY(-1); transform: scaleY(-1); }
        .list-line-8 { background-image: url("{{ asset('storage/images/cung-chieu-02.png') }}"); -webkit-transform: scaleY(-1); transform: scaleY(-1); }
        .list-line-9 { background-image: url("{{ asset('storage/images/cung-chieu-01.png') }}"); -webkit-transform: scaleY(-1); transform: scaleY(-1); }
        .list-line-10 { background-image: url("{{ asset('storage/images/cung-chieu-01.png') }}"); }
        .list-line-11 { background-image: url("{{ asset('storage/images/cung-chieu-02.png') }}"); }

        /* Specific con giap images (copying tuvi.vn logic for animal masks) */
        .ty { background-image: url("{{ asset('storage/images/con_giap_ty.png') }}"); }
        .suu { background-image: url("{{ asset('storage/images/con_giap_suu.png') }}"); }
        .dan { background-image: url("{{ asset('storage/images/con_giap_dan.png') }}"); }
        .mao { background-image: url("{{ asset('storage/images/con_giap_mao.png') }}"); }
        .thin { background-image: url("{{ asset('storage/images/con_giap_thin.png') }}"); }
        .ti { background-image: url("{{ asset('storage/images/con_giap_ti.png') }}"); }
        .ngo { background-image: url("{{ asset('storage/images/con_giap_ngo.png') }}"); }
        .mui { background-image: url("{{ asset('storage/images/con_giap_mui.png') }}"); }
        .than { background-image: url("{{ asset('storage/images/con_giap_than.png') }}"); }
        .dau { background-image: url("{{ asset('storage/images/con_giap_dau.png') }}"); }
        .tuat { background-image: url("{{ asset('storage/images/con_giap_tuat.png') }}"); }
        .hoi { background-image: url("{{ asset('storage/images/con_giap_hoi.png') }}"); }
    </style>
@endpush

@section('content')
<div class="container mt-4 mb-5">
    <div class="table-responsive">
        <table class="table-la-so">
            <tbody>
                {{-- Row 1: Tỵ Ngọ Mùi Thân --}}
                <tr>
                    @foreach(['Tỵ', 'Ngọ', 'Mùi', 'Thân'] as $branch)
                        <x-horoscope.cung :house="$housesByBranch[$branch] ?? null" :horoscope="$horoscope" :branch="$branch" />
                    @endforeach
                </tr>
                
                {{-- Row 2: Thìn - Thiên Bàn - Dậu --}}
                <tr>
                    <x-horoscope.cung :house="$housesByBranch['Thìn'] ?? null" :horoscope="$horoscope" branch="Thìn" />
                    
                    <td colspan="2" rowspan="2" class="thien-ban" data-menh-chi-index="{{ $horoscope->meta->menh_chi_index ?? 0 }}">
                        <div class="view-con-giap-la-so {{ 'list-line-' . ($horoscope->meta->menh_chi_index ?? 0) }}"></div>
                        <h1 style="font-family: UTM-Azuki;font-size: 29px;letter-spacing: normal;line-height: 31px;">LÁ SỐ TỬ VI</h1>
                        <div class="info-box">
                            <div class="info-row">
                                <span class="info-label">Họ tên:</span>
                                <span class="info-value text-uppercase">{{ $horoscope->name }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Năm sinh:</span>
                                <span class="info-value">{{ $horoscope->birth_gregorian->format('d/m/Y H:i') }} (DL)</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Âm lịch:</span>
                                <span class="info-value">{{ $horoscope->birth_lunar_day }}/{{ $horoscope->birth_lunar_month }}/{{ $horoscope->birth_lunar_year }} - {{ $horoscope->can_chi_year }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Giới tính:</span>
                                <span class="info-value">{{ $horoscope->gender == 'male' ? 'Nam' : 'Nữ' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Âm Dương:</span>
                                <span class="info-value">{{ $horoscope->am_duong }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Bản Mệnh:</span>
                                <span class="info-value">{{ $horoscope->nap_am }} - {{ $horoscope->cuc }} <br> <small class="text-muted">({{ $horoscope->meta->extra['menh_cuc_relation'] ?? '' }})</small></span>
                            </div>
                            {{-- Remove separate Cuc row if merged --}}
                            <div class="info-row">
                                <span class="info-label">Chủ Mệnh:</span>
                                <span class="info-value">{{ $horoscope->meta->chu_menh ?? '---' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Chủ Thân:</span>
                                <span class="info-value">{{ $horoscope->meta->chu_than ?? '---' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Lai Nhân Cung:</span>
                                @php
                                    $laiNhanHouse = collect([
                                        'MENH' => 'Mệnh', 'PHU_MAU' => 'Phụ Mẫu', 'PHUC_DUC' => 'Phúc Đức', 'DIEN_TRACH' => 'Điền Trạch',
                                        'QUAN_LOC' => 'Quan Lộc', 'NO_BOC' => 'Nô Bộc', 'THIEN_DI' => 'Thiên Di', 'TAT_ACH' => 'Tật Ách',
                                        'TAI_BACH' => 'Tài Bạch', 'TU_TUC' => 'Tử Tức', 'PHU_THE' => 'Phu Thê', 'HUYNH_DE' => 'Huynh Đệ'
                                    ])->get($horoscope->meta->lai_nhan_cung ?? '---', '---');
                                @endphp
                                <span class="info-value">{{ $laiNhanHouse }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Cân Lượng:</span>
                                <span class="info-value">{{ $horoscope->can_luong ?? '---' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Năm xem:</span>
                                <span class="info-value">{{ $horoscope->view_year ?? '---' }} ({{ $horoscope->view_year - $horoscope->birth_gregorian->year }} tuổi)</span>
                            </div>
                        </div>
                    </td>

                    <x-horoscope.cung :house="$housesByBranch['Dậu'] ?? null" :horoscope="$horoscope" branch="Dậu" />
                </tr>

                {{-- Row 3: Mão - Thiên Bàn - Tuất --}}
                <tr>
                    <x-horoscope.cung :house="$housesByBranch['Mão'] ?? null" :horoscope="$horoscope" branch="Mão" />
                    {{-- Thiên bàn occupies here --}}
                    <x-horoscope.cung :house="$housesByBranch['Tuất'] ?? null" :horoscope="$horoscope" branch="Tuất" />
                </tr>

                {{-- Row 4: Dần Sửu Tý Hợi --}}
                <tr>
                    @foreach(['Dần', 'Sửu', 'Tý', 'Hợi'] as $branch)
                        <x-horoscope.cung :house="$housesByBranch[$branch] ?? null" :horoscope="$horoscope" :branch="$branch" />
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Luận Giải Section --}}
    <div class="mt-5">
        <h3 class="text-center text-danger font-weight-bold mb-4" style="color: #a21313;">LUẬN GIẢI CHI TIẾT</h3>
        
        @if($horoscope->readings->isNotEmpty())
            <div class="row">
                @foreach($horoscope->readings as $reading)
                    <div class="col-md-12 mb-3">
                        <div class="card border-0 shadow-sm" style="background-color: #fffdf5; border-left: 4px solid #a21313 !important;">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold" style="color: #a21313;">
                                    @php
                                        $houseLabel = match($reading->house_code) {
                                            'MENH' => 'Cung Mệnh', 'PHU_MAU' => 'Cung Phụ Mẫu', 'PHUC_DUC' => 'Cung Phúc Đức',
                                            'DIEN_TRACH' => 'Cung Điền Trạch', 'QUAN_LOC' => 'Cung Quan Lộc', 'NO_BOC' => 'Cung Nô Bộc',
                                            'THIEN_DI' => 'Cung Thiên Di', 'TAT_ACH' => 'Cung Tật Ách', 'TAI_BACH' => 'Cung Tài Bạch',
                                            'TU_TUC' => 'Cung Tử Tức', 'PHU_THE' => 'Cung Phu Thê', 'HUYNH_DE' => 'Cung Huynh Đệ',
                                            default => 'Tổng Quan'
                                        };
                                    @endphp
                                    {{ $houseLabel }}
                                </h5>
                                <div class="card-text text-justify">
                                    {!! $reading->text !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning text-center">
                Chưa có lời giải cho lá số này. Hãy thử cập nhật thông tin hoặc chờ hệ thống xử lý.
            </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script type="module">
    $(document).ready(function() {
        saveHistory();

        // Store original class of the central view (Only target the one in Thien Ban)
        const $centralView = $('.thien-ban .view-con-giap-la-so');
        const originalClass = $centralView.attr('class');

        // Highlight relations on hover
        $('.cung').hover(function() {
            const currentHouseBranch = $(this).data('branch');
            const relations = $(this).data('relations');
            const branchIndex = $(this).data('branch-index');

            // 1. Update Central View Line
            if (branchIndex !== undefined) {
                $centralView.attr('class', 'view-con-giap-la-so list-line-' + branchIndex);
            }

            // 2. Highlight Current House
            $(this).addClass('highlight-current');

            // 3. Highlight related houses
            if (relations && relations.length > 0) {
                relations.forEach(relation => {
                    const targetBranch = relation.to_branch_code;
                    const relationType = relation.type; 

                    $(`td.cung[data-branch="${targetBranch}"]`).addClass(`highlight-${relationType}`);
                });
            }
        }, function() {
            $(`td.cung`).removeClass('highlight-current highlight-tam-hop highlight-xung highlight-nhi-hop highlight-luc-hai');
            $centralView.attr('class', originalClass);
        });
    });

    function saveHistory() {
        const currentItem = {
            name: "{{ $horoscope->name }}",
            slug: "{{ $horoscope->slug }}",
            date: "{{ now()->format('d/m/Y H:i') }}"
        };

        let history = JSON.parse(localStorage.getItem('tuvi_history')) || [];
        history = history.filter(item => item.slug !== currentItem.slug);
        history.unshift(currentItem);
        if (history.length > 10) history.pop();
        localStorage.setItem('tuvi_history', JSON.stringify(history));
    }
</script>
@endpush