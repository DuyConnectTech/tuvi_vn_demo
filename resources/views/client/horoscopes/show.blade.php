@extends('client.layouts.app')

@section('title', 'Lá Số Tử Vi - ' . $horoscope->name)

@push('css')
    <style>
        body { background-color: #efecdd; color: #333; } /* Override body bg */
        .table-la-so { width: 100%; max-width: 1000px; margin: 0 auto; border-collapse: collapse; background-color: #f1ece3; border: 2px solid #000; }
        .table-la-so td { border: 1px solid #888; padding: 0; vertical-align: top; width: 25%; height: 250px; position: relative; }
        
        /* Cung View */
        .cung-view { display: flex; flex-direction: column; height: 100%; justify-content: space-between; padding: 5px; }
        
        /* Top: Can Chi Cung + Tên Cung + Chính Tinh */
        .cung-top { text-align: center; border-bottom: 1px dashed #ccc; padding-bottom: 5px; margin-bottom: 5px; }
        .text-dia-chi { font-weight: bold; font-size: 14px; text-transform: uppercase; color: #666; }
        .text-ten-cung { font-weight: bold; font-size: 16px; color: #a21313; display: inline-block; padding: 2px 8px; border-radius: 3px; margin: 2px 0; }
        .text-ten-cung.menh { background: #a21313; color: #fff; } /* Mệnh */
        .text-ten-cung.than { background: #d4a017; color: #000; } /* Thân */
        .text-ten-cung.binh-hoa { background: #ccc; color: #000; } /* Các cung khác */
        
        .chinh-tinh { margin-top: 5px; }
        .sao-chinh { font-weight: bold; font-size: 15px; display: block; }
        .sao-chinh.Miếu, .sao-chinh.Vượng { color: #d00; } /* Miếu - Đỏ đậm */
        .sao-chinh.Đắc { color: #009130; } /* Đắc - Xanh */
        .sao-chinh.Bình { color: #555; }
        .sao-chinh.Hãm { color: #777; font-style: italic; } /* Hãm - Xám nghiêng */

        /* Middle: Phụ Tinh */
        .cung-middle { flex-grow: 1; display: flex; }
        .sao-tot { width: 50%; text-align: left; padding-right: 2px; }
        .sao-xau { width: 50%; text-align: right; padding-left: 2px; }
        
        .sao-phu { display: block; margin-bottom: 1px; font-size: 13px; }
        .sao-tot .sao-phu { color: #000; } /* Phụ tinh cát */
        .sao-xau .sao-phu { color: #555; } /* Phụ tinh sát */
        
        /* Special Stars Colors (override general sao-phu) */
        .sao-loc-ton, .sao-hoa-loc { color: #009130 !important; font-weight: bold; } /* Lộc - Xanh */
        .sao-hoa-quyen { color: #d00 !important; font-weight: bold; } /* Quyền - Đỏ */
        .sao-hoa-khoa { color: #009130 !important; } /* Khoa - Xanh */
        .sao-hoa-ky, .sao-da-la, .sao-kinh-duong { color: #000 !important; font-weight: bold; } /* Kỵ/Sát - Đen đậm */
        .sao-hoa-tinh, .sao-linh-tinh, .sao-dia-khong, .sao-dia-kiep { color: #d00 !important; } /* Sát tinh đặc biệt */

        /* Tuần Triệt Specific */
        .sao-tuan-triet {
            position: absolute;
            top: 5px; /* Adjust as needed */
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            background-color: #000;
            padding: 2px 5px;
            border-radius: 3px;
            z-index: 10;
        }
        .sao-tuan { left: 5px; }
        .sao-triet { right: 5px; }
        
        /* Bottom: Đại Vận, Tiểu Vận */
        .cung-bottom { border-top: 1px dashed #ccc; padding-top: 5px; margin-top: 5px; display: flex; justify-content: space-between; font-size: 12px; color: #666; }
        .dai-van-num { font-weight: bold; font-size: 16px; color: #a21313; }

        /* Thiên Bàn (Center) */
        .thien-ban { text-align: center; padding: 20px !important; background: #fff; }
        .thien-ban h1 { font-family: 'Times New Roman', serif; color: #a21313; margin-bottom: 20px; }
        .info-row { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding: 8px 0; }
        .info-label { font-weight: bold; color: #555; }
        .info-value { font-weight: bold; color: #000; }

        /* Responsive */
        @media (max-width: 768px) {
            .table-la-so td { display: block; width: 100%; height: auto; margin-bottom: 10px; border: 1px solid #000; }
            .thien-ban { display: block; width: 100%; }
        }

        /* Highlight classes for relations */
        .highlight-current { background-color: #fff; box-shadow: inset 0 0 0 3px #d4a017; z-index: 10; } /* Current: Gold Border Inner */
        .highlight-tam-hop { background-color: #e6ffe6; border: 2px solid #0a0; } /* Light green for Tam Hop */
        .highlight-xung { background-color: #ffe6e6; border: 2px solid #a00; } /* Light red for Lục Xung */
        .highlight-nhi-hop { background-color: #e6e6ff; border: 2px solid #00a; } /* Light blue for Nhị Hợp */
        .highlight-luc-hai { background-color: #fffbe6; border: 2px solid #aa0; } /* Light yellow for Lục Hại */

        /* Con Giáp - Thiên Bàn (từ tuvi.vn style) */
        .view-con-giap-la-so {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            right: 0;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
        }

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

        /* Con Giáp trong Cung */
        .cung-top .view-con-giap-la-so {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-size: 80%; /* Adjusted for smaller size in cung */
            background-repeat: no-repeat;
            background-position: center bottom; /* Position at bottom center */
            opacity: 0.1; /* Make it subtle */
            z-index: 1;
            transition: opacity 0.3s ease; /* Smooth transition */
        }
        
        /* Highlight Con Giap when House is Highlighted */
        .cung.highlight-tam-hop .view-con-giap-la-so,
        .cung.highlight-xung .view-con-giap-la-so,
        .cung.highlight-nhi-hop .view-con-giap-la-so,
        .cung.highlight-luc-hai .view-con-giap-la-so,
        .cung.highlight-current .view-con-giap-la-so {
            opacity: 0.5; /* Increase visibility */
        }

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
                        @include('client.horoscopes._cung', ['house' => $housesByBranch[$branch] ?? null, 'horoscope' => $horoscope, 'branch' => $branch])
                    @endforeach
                </tr>
                
                {{-- Row 2: Thìn - Thiên Bàn - Dậu --}}
                <tr>
                    @include('client.horoscopes._cung', ['house' => $housesByBranch['Thìn'] ?? null, 'horoscope' => $horoscope, 'branch' => 'Thìn'])
                    
                    <td colspan="2" rowspan="2" class="thien-ban" data-menh-chi-index="{{ $horoscope->meta->menh_chi_index ?? 0 }}">
                        <div class="view-con-giap-la-so {{ 'list-line-' . ($horoscope->meta->menh_chi_index ?? 0) }}"></div>
                        <h1>LÁ SỐ TỬ VI</h1>
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

                    @include('client.horoscopes._cung', ['house' => $housesByBranch['Dậu'] ?? null, 'horoscope' => $horoscope, 'branch' => 'Dậu'])
                </tr>

                {{-- Row 3: Mão - Thiên Bàn - Tuất --}}
                <tr>
                    @include('client.horoscopes._cung', ['house' => $housesByBranch['Mão'] ?? null, 'horoscope' => $horoscope, 'branch' => 'Mão'])
                    {{-- Thiên bàn occupies here --}}
                    @include('client.horoscopes._cung', ['house' => $housesByBranch['Tuất'] ?? null, 'horoscope' => $horoscope, 'branch' => 'Tuất'])
                </tr>

                {{-- Row 4: Dần Sửu Tý Hợi --}}
                <tr>
                    @foreach(['Dần', 'Sửu', 'Tý', 'Hợi'] as $branch)
                        @include('client.horoscopes._cung', ['house' => $housesByBranch[$branch] ?? null, 'horoscope' => $horoscope, 'branch' => $branch])
                    @endforeach
                </tr>
            </tbody>
        </table>
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
        }

        // Check if jQuery is loaded
        if (window.jQuery) {
            initApp();
        } else {
            // Retry after 100ms if loading via async script
            var checkInterval = setInterval(function() {
                if (window.jQuery) {
                    clearInterval(checkInterval);
                    initApp();
                }
            }, 100);
        }
    })();

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