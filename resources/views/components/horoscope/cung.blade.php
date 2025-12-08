@props(['house', 'branch', 'horoscope'])

@php
    use App\Enums\Chi;

    $currentBranchName = $house->branch ?? $branch;
    $chiEnum = Chi::fromLabel($currentBranchName);

    // Fallback to defaults if not found (should not happen with valid data)
    $currentIndex = $chiEnum ? $chiEnum->value : 0;
    $branchSlug = $chiEnum ? $chiEnum->slug() : 'unknown';
@endphp

<td class="cung" 
    data-branch="{{ $branchSlug }}" 
    data-branch-index="{{ $currentIndex }}" 
    data-relations="{{ json_encode($house->relations ?? []) }}"
    data-chi="{{ $currentIndex }}"
    data-cung-full-name="{{ $house->can ?? '' }}.{{ $house->branch ?? $branch }}"
>
    <div class="cung-view" id="cung{{ $house->house_order ?? 0 }}">
        @if($house)
            {{-- Background Con Giap Overlay for the whole cung-view --}}
            <div class="view-con-giap-la-so {{ strtolower($house->branch) }}"></div>

            <div class="cung-top">
                <div class="view-cung-top">
                    {{-- Left: Can Chi & Element --}}
                    <div>
                        <p class="text-dia-chi txt-tiny-mid">
                            {{ $house->can ? mb_substr($house->can, 0, 1) . '.' : '' }}{{ $house->branch }}
                        </p>
                        
                        @php
                            $isYang = in_array($house->branch, ['Tý', 'Dần', 'Thìn', 'Ngọ', 'Thân', 'Tuất']);
                            $sign = $isYang ? '+' : '-';
                        @endphp
                        <p class="text-dia-chi txt-tiny-mid m-b-5">{{ $sign }}{{ $house->element }}</p>
                    </div>
                    
                    {{-- Center: House Name & Main Stars --}}
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
                                    {{ $sign }}{{ $star->name }} ({{ $star->pivot->status }})
                                </p>
                            @endif
                        @endforeach
                    </div>
                    
                    {{-- Right: Dai Van & Month --}}
                    <div class="view-cung-dai-van">
                        <p class="text-dia-chi txt-tiny-mid text-dai-van-number">{{ $house->dai_van_start_age ?? '--' }}</p>
                        {{-- Display only the first month if multiple, or all --}}
                        <p class="text-dia-chi txt-tiny-mid">{{ $house->nguyet_han ?? 'Th.--' }}</p> 
                    </div>
                </div>
            </div>

            <div class="cung-middle">
                @php
                    $trangSinhSlugs = ['trang-sinh', 'moc-duc', 'quan-doi', 'lam-quan', 'de-vuong', 'suy', 'benh', 'tu', 'mo', 'tuyet', 'thai', 'duong'];
                    // Expanded bad stars list including transit stars
                    $badStarSlugs = [
                        'da-la', 'kinh-duong', 'dia-khong', 'dia-kiep', 'hoa-tinh', 'linh-tinh', 'hoa-ky', 
                        'tang-mon', 'bach-ho', 'thien-khoc', 'thien-hu', 'co-than', 'qua-tu', 'pha-toai', 'kiep-sat', 'luu-ha', 'thien-hinh',
                        'luu-da-la', 'luu-kinh-duong', 'luu-bach-ho', 'luu-tang-mon', 'luu-thien-khoc', 'luu-thien-hu', 'luu-hoa-ky'
                    ];
                @endphp
                
                <div class="sao-tot">
                    @foreach($house->stars as $star)
                        @if(!$star->pivot->is_main && !in_array($star->slug, $badStarSlugs) && !in_array($star->slug, $trangSinhSlugs) && $star->group_type != 'sat_tinh')
                            <div class="txt-tiny text-sao-xau-tot" style="color: {{ $star->color }}">
                                {{ $star->name }}
                                @if($star->pivot->status != 'Bình') <small>({{ $star->pivot->status }})</small> @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <div class="sao-xau">
                    @foreach($house->stars as $star)
                        @if(!$star->pivot->is_main && (in_array($star->slug, $badStarSlugs) || $star->group_type == 'sat_tinh') && !in_array($star->slug, $trangSinhSlugs))
                            <div class="txt-tiny text-sao-xau-tot font-weight-bold" style="color: {{ $star->color }}">
                                {{ $star->name }}
                                @if($star->pivot->status != 'Bình') <small>({{ $star->pivot->status }})</small> @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="cung-middle-tu-hoa-phai" style="display: none">
                {{-- Placeholder for Tu Hoa Phai --}}
            </div>

            <div class="cung-bottom">
                {{-- Placeholder for Luu Dai Van (DV.XXX) - Not yet calculated in Service --}}
                <span class="text-tieu-van txt-tiny">ĐV.--</span>
                
                @php
                    $trangSinhStar = $house->stars->firstWhere(function($star) use ($trangSinhSlugs) {
                        return in_array($star->slug, $trangSinhSlugs);
                    });
                @endphp
                @if($trangSinhStar)
                    <span class="txt-tiny-mid white-space-nowrap" style="color: #000">{{ $trangSinhStar->name }}</span>
                @else
                    <span class="txt-tiny-mid">--</span>
                @endif
                
                <span class="text-tieu-van txt-tiny">{{ $house->tieu_han ?? 'LN.--' }}</span>
            </div>

            {{-- Tên Chi cung ở đáy --}}
            <div class="khoi-tieu-han-bottom txt-tiny" style="text-align: center; margin-top: 2px;">
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
