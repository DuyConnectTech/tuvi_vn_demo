@php
    $branchIndices = array_flip(['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi']);
    $currentBranchName = $house->branch ?? $branch;
    $currentIndex = $branchIndices[$currentBranchName] ?? 0;
    // Normalize branch for data attribute to match relation codes (ty, suu...)
    // Manual mapping to ensure match with BranchRelationSeeder keys or Str::slug
    // BranchRelationSeeder uses: ty, suu, dan, mao, thin, ti, ngo, mui, than, dau, tuat, hoi.
    // Str::slug('Tý') -> 'ty'. 'Tỵ' -> 'ty'? No, 'ty'. 'Sửu' -> 'suu'. 
    // Warning: 'Tý' and 'Tỵ' might conflict if just slug. 'ty' vs 'ty'.
    // Str::slug('Tỵ') is 'ty'. Str::slug('Tý') is 'ty'. -> CONFLICT!
    
    // We need a precise map.
    $branchSlugMap = [
        'Tý' => 'ty', 'Sửu' => 'suu', 'Dần' => 'dan', 'Mão' => 'mao',
        'Thìn' => 'thin', 'Tỵ' => 'ti', 'Ngọ' => 'ngo', 'Mùi' => 'mui',
        'Thân' => 'than', 'Dậu' => 'dau', 'Tuất' => 'tuat', 'Hợi' => 'hoi'
    ];
    $branchSlug = $branchSlugMap[$currentBranchName] ?? 'unknown';
@endphp
<td class="cung" data-branch="{{ $branchSlug }}" data-branch-index="{{ $currentIndex }}" data-relations="{{ json_encode($house->relations ?? []) }}">
    <div class="cung-view">
        @if($house)
            <div class="cung-top">
                <div class="view-con-giap-la-so {{ strtolower($house->branch) }}"></div>
                <div class="view-cung-top">
                    <div>
                        <p class="text-dia-chi txt-tiny-mid">{{ $house->branch }}</p>
                        <p class="text-dia-chi txt-tiny-mid m-b-5">{{ $house->element }}</p>
                    </div>
                    
                    <div class="chinh-tinh">
                        <div class="d-flex justify-content-center">
                            <p class="text-sao-chinh-tinh txt-tiny-bold" 
                               style="color: {{ strtolower($house->code) == 'menh' ? '#ff0000' : (strtolower($house->code) == 'than' ? '#ffa000' : '#999999') }}">
                                {{ $house->label }}
                            </p>
                            @if(isset($horoscope->meta->than_cung_code) && $horoscope->meta->than_cung_code == $house->code && strtolower($house->code) != 'menh')
                                <span class="text-sao-chinh-tinh txt-tiny-bold" style="color: #ffa000">&lt;Thân&gt;</span>
                            @endif
                        </div>

                        @foreach($house->stars as $star)
                            @if($star->pivot->is_main)
                                <p class="text-chinh-chinh txt-tiny-bold" style="color: {{ $star->color }}">
                                    {{ $star->name }} ({{ $star->pivot->status }})
                                </p>
                            @endif
                        @endforeach
                    </div>
                    
                    <div class="view-cung-dai-van">
                        {{-- Đại Vận: Chưa tính chính xác, placeholder --}}
                        <p class="text-dia-chi txt-tiny-mid text-dai-van-number">--</p>
                        <p class="text-dia-chi txt-tiny-mid">Th.{{ $house->house_order }}</p>
                    </div>
                </div>
            </div>

            <div class="cung-middle">
                <div class="sao-tot">
                    @foreach($house->stars as $star)
                        @if(!$star->pivot->is_main && in_array($star->group_type, ['cat_tinh', 'phu_tinh', 'tu_hoa']) && $star->slug != 'hoa-ky')
                            <div class="txt-tiny text-sao-xau-tot" style="color: {{ $star->color }}">
                                {{ $star->name }}
                                @if($star->pivot->status != 'Bình') <small>({{ $star->pivot->status }})</small> @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="sao-xau">
                    @foreach($house->stars as $star)
                        @if(!$star->pivot->is_main && ($star->group_type == 'sat_tinh' || $star->slug == 'hoa-ky'))
                            <div class="txt-tiny text-sao-xau-tot font-weight-bold" style="color: {{ $star->color }}">
                                {{ $star->name }}
                                @if($star->pivot->status != 'Bình') <small>({{ $star->pivot->status }})</small> @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="cung-bottom">
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
                
                <span class="text-tieu-van txt-tiny">ĐV.--</span>
                
                @if($trangSinhStar)
                    <span class="txt-tiny-mid white-space-nowrap" style="color: #000">{{ $trangSinhStar->name }}</span>
                @else
                    <span class="txt-tiny-mid">--</span>
                @endif
                
                <span class="text-tieu-van txt-tiny">LN.--</span>
            </div>

            <div class="khoi-tieu-han-bottom txt-tiny">
                <span>{{ $branch }}</span>
            </div>

            {{-- Tuần / Triệt --}}
            @php
                $tuanStar = $house->stars->firstWhere('slug', 'tuan');
                $trietStar = $house->stars->firstWhere('slug', 'triet');
            @endphp
            @if($tuanStar || $trietStar)
                <div class="triet-position-top-center" style="position: absolute; top: 0; width: 100%; text-align: center;">
                    <span class="txt-tiny text-white" style="background: #000; padding: 1px 4px; border-radius: 0 0 4px 4px;">
                        {{ $tuanStar ? 'Tuần' : '' }} {{ ($tuanStar && $trietStar) ? '-' : '' }} {{ $trietStar ? 'Triệt' : '' }}
                    </span>
                </div>
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
            {{-- Empty House --}}
            <div class="text-center text-muted mt-5">{{ $branch }}</div>
        @endif
    </div>
</td>