@php
    $branchIndices = array_flip(['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi']);
    $currentIndex = $branchIndices[$house->branch ?? $branch] ?? 0;
@endphp
<td class="cung" data-branch="{{ $house->branch ?? $branch }}" data-branch-index="{{ $currentIndex }}" data-relations="{{ json_encode($house->relations ?? []) }}">
    <div class="cung-view">
        @if($house)
            <div class="cung-top">
                <div class="view-con-giap-la-so {{ strtolower($house->branch) }}"></div>
                <div class="text-dia-chi">{{ $house->branch }} <small>({{ $house->element }})</small></div>
                <div class="text-ten-cung {{ strtolower($house->code) == 'menh' ? 'menh' : (isset($horoscope->meta->than_cung_code) && $horoscope->meta->than_cung_code == $house->code ? 'than' : 'binh-hoa') }}">
                    {{ $house->label }}
                    @if(isset($horoscope->meta->than_cung_code) && $horoscope->meta->than_cung_code == $house->code && strtolower($house->code) != 'menh')
                        <span class="text-sao-chinh-tinh">&lt;Thân&gt;</span>
                    @endif
                </div>
                
                <div class="chinh-tinh">
                    @foreach($house->stars as $star)
                        @if($star->pivot->is_main)
                            <span class="sao-chinh {{ $star->pivot->status }}">
                                {{ $star->name }} ({{ $star->pivot->status }})
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="cung-middle">
                <div class="sao-tot">
                    @foreach($house->stars as $star)
                        @if(!$star->pivot->is_main && in_array($star->group_type, ['cat_tinh', 'phu_tinh', 'tu_hoa']) && $star->slug != 'hoa-ky')
                            <span class="sao-phu sao-{{ $star->slug }}">
                                {{ $star->name }}
                                @if($star->pivot->status != 'Bình') <small>({{ $star->pivot->status }})</small> @endif
                            </span>
                        @endif
                    @endforeach
                </div>
                <div class="sao-xau">
                    @foreach($house->stars as $star)
                        @if(!$star->pivot->is_main && ($star->group_type == 'sat_tinh' || $star->slug == 'hoa-ky'))
                            <span class="sao-phu sao-{{ $star->slug }}">
                                {{ $star->name }}
                                @if($star->pivot->status != 'Bình') <small>({{ $star->pivot->status }})</small> @endif
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="cung-bottom">
                {{-- Đại Vận: Chưa tính --}}
                <span class="dai-van-num" title="Đại vận">--</span>
                
                {{-- Vòng Tràng Sinh --}}
                @php
                    $trangSinhStar = $house->stars->firstWhere(function($star) {
                        return str_contains($star->name, 'Tràng Sinh') || str_contains($star->name, 'Mộc Dục') ||
                               str_contains($star->name, 'Quan Đới') || str_contains($star->name, 'Lâm Quan') ||
                               str_contains($star->name, 'Đế Vượng') || str_contains($star->name, 'Suy') ||
                               str_contains($star->name, 'Bệnh') || str_contains($star->name, 'Tử') ||
                               str_contains($star->name, 'Mộ') || str_contains($star->name, 'Tuyệt') ||
                               str_contains($star->name, 'Thai') || str_contains($star->name, 'Dưỡng');
                    });
                @endphp
                @if($trangSinhStar)
                    <span class="text-tieu-van txt-tiny-mid">{{ $trangSinhStar->name }}</span>
                @else
                    <span class="text-tieu-van txt-tiny-mid">--</span>
                @endif
                
                {{-- Tiểu Vận: Chưa tính --}}
                <span>{{ $branch }}</span>
            </div>

            {{-- Tuần / Triệt --}}
            @php
                $tuanStar = $house->stars->firstWhere('slug', 'tuan');
                $trietStar = $house->stars->firstWhere('slug', 'triet');
            @endphp
            @if($tuanStar)
                <div class="sao-tuan-triet sao-tuan">Tuần</div>
            @endif
            @if($trietStar)
                <div class="sao-tuan-triet sao-triet">Triệt</div>
            @endif

            {{-- Image for relations (Tam Hop, Xung...) --}}
            @if(isset($house->relations) && !empty($house->relations))
                @foreach($house->relations as $relation)
                    <img src="{{ asset('storage/images/' . $relation['type'] . '.png') }}" 
                         alt="{{ $relation['type'] }}" 
                         class="relation-icon relation-{{ $relation['type'] }}" 
                         data-target-branch="{{ $relation['to_branch_code'] }}"
                         style="position: absolute; width: 30px; height: 30px; bottom: 5px; right: 5px; display: none;">
                @endforeach
            @endif
        @else
            {{-- Empty House (Should not happen if initialized correctly) --}}
            <div class="text-center text-muted mt-5">{{ $branch }}</div>
        @endif
    </div>
</td>
