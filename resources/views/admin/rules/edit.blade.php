@extends('admin.layouts.app')

@section('page_title', 'Cập nhật Rule')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.rules.index') }}">Danh sách Rules</a></li>
    <li class="breadcrumb-item active">Cập nhật</li>
@endsection

@section('content')
    <form action="{{ route('admin.rules.update', $rule) }}" method="POST" class="container-fluid">
        @csrf
        @method('PUT')
        <div class="row">
        {{-- Form Edit Rule --}}
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Thông tin Rule: {{ $rule->code }}</h3>
                </div>
                {{-- <form> removed from here --}}
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Mã Rule (Code) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $rule->code) }}">
                                    @error('code')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority">Độ ưu tiên</label>
                                    <input type="number" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" value="{{ old('priority', $rule->priority) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="scope">Phạm vi (Scope)</label>
                                    <select class="form-control" id="scope" name="scope">
                                        <option value="house" {{ old('scope', $rule->scope) == 'house' ? 'selected' : '' }}>House</option>
                                        <option value="global" {{ old('scope', $rule->scope) == 'global' ? 'selected' : '' }}>Global</option>
                                        <option value="period" {{ old('scope', $rule->scope) == 'period' ? 'selected' : '' }}>Period</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="target_house">Cung áp dụng</label>
                                    <select class="form-control" id="target_house" name="target_house">
                                        <option value="">-- Không chọn --</option>
                                        @foreach(['MENH', 'PHU_MAU', 'PHUC_DUC', 'DIEN_TRACH', 'QUAN_LOC', 'NO_BOC', 'THIEN_DI', 'TAT_ACH', 'TAI_BACH', 'TU_TUC', 'PHU_THE', 'HUYNH_DE'] as $h)
                                            <option value="{{ $h }}" {{ old('target_house', $rule->target_house) == $h ? 'selected' : '' }}>{{ $h }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="text_template">Nội dung luận giải</label>
                            <textarea class="form-control" id="text_template" name="text_template" rows="5">{{ old('text_template', $rule->text_template) }}</textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $rule->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="custom-control-label">Kích hoạt</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật Rule (Lưu tất cả)</button>
                        <a href="{{ route('admin.rules.index') }}" class="btn btn-default ml-2">Quay lại</a>
                    </div>
                {{-- </form> removed --}}
            </div>
        </div>

        {{-- Section Conditions Management --}}
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Điều kiện (Conditions)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <button type="button" class="btn btn-success btn-sm" id="add-condition">
                            <i class="fas fa-plus"></i> Thêm Điều kiện
                        </button>
                    </div>
                    
                    <table class="table table-bordered" id="conditions-table">
                        <thead>
                            <tr>
                                <th style="width: 15%">Loại</th>
                                <th style="width: 15%">Trường</th>
                                <th style="width: 10%">Toán tử</th>
                                <th style="width: 30%">Giá trị</th>
                                <th style="width: 10%">Or Group</th>
                                <th style="width: 10%">Cung</th>
                                <th style="width: 10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Conditions will be added here by JavaScript --}}
                        </tbody>
                    </table>

                    {{-- Hidden HTML Template for a new condition row --}}
                    <template id="condition-template">
                        <tr>
                            <td>
                                <select class="form-control form-control-sm condition-type" name="conditions[INDEX][type]">
                                    @foreach($conditionTypes as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm condition-field" name="conditions[INDEX][field]" placeholder="e.g., house.stars">
                            </td>
                            <td>
                                <select class="form-control form-control-sm condition-operator" name="conditions[INDEX][operator]">
                                    @foreach($operators as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                {{-- Value input will be dynamically rendered here by JS --}}
                                <input type="text" class="form-control form-control-sm condition-value" name="conditions[INDEX][value]" placeholder="Giá trị">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm condition-or-group" name="conditions[INDEX][or_group]" placeholder="Optional">
                            </td>
                            <td>
                                <select class="form-control form-control-sm condition-house-code" name="conditions[INDEX][house_code]">
                                    <option value="">-- Cung --</option>
                                    @foreach($allHouses as $house)
                                        <option value="{{ $house }}">{{ $house }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-condition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection

@push('js')
<script>
    // Global data passed from Controller
    const ALL_STARS = @json($allStars);
    const ALL_HOUSES = @json($allHouses);
    const CONDITION_TYPES = @json($conditionTypes);
    const OPERATORS = @json($operators);
    const EXISTING_CONDITIONS = @json($rule->conditions->map(function($cond) {
        $cond->value = is_string($cond->value) ? json_decode($cond->value) : $cond->value;
        return $cond;
    }));

    let conditionIndex = 0; // To keep track of unique index for each condition row

    $(document).ready(function() {
        // --- Event Listener for Add Condition Button ---
        $('#add-condition').on('click', function() {
            addConditionRow({});
        });

        // --- Event Listener for Remove Condition Button (Delegated) ---
        $('#conditions-table').on('click', '.remove-condition', function() {
            $(this).closest('tr').remove();
        });

        // --- Event Listener for Type and Operator Change (Delegated) ---
        $('#conditions-table').on('change', '.condition-type, .condition-operator', function() {
            const row = $(this).closest('tr');
            renderValueInput(row);
        });

        // --- Initialize Existing Conditions ---
        if (EXISTING_CONDITIONS.length > 0) {
            EXISTING_CONDITIONS.forEach(function(condition) {
                addConditionRow(condition);
            });
        } else {
            // Add one empty row if no existing conditions
            addConditionRow({});
        }

        // --- Function to Add a Condition Row ---
        function addConditionRow(conditionData) {
            const template = $('#condition-template').html();
            // Replace INDEX with current index
            let newRow = $(template.replace(/INDEX/g, conditionIndex));
            
            // Populate data if available
            if (conditionData.type) newRow.find('.condition-type').val(conditionData.type);
            if (conditionData.field) newRow.find('.condition-field').val(conditionData.field);
            if (conditionData.operator) newRow.find('.condition-operator').val(conditionData.operator);
            if (conditionData.or_group) newRow.find('.condition-or-group').val(conditionData.or_group);
            if (conditionData.house_code) newRow.find('.condition-house-code').val(conditionData.house_code);

            $('#conditions-table tbody').append(newRow);
            renderValueInput(newRow, conditionData.value); // Render value input and populate its value
            conditionIndex++;
        }

        // --- Function to Dynamically Render Value Input ---
        function renderValueInput(row, initialValue = null) {
            const type = row.find('.condition-type').val();
            const operator = row.find('.condition-operator').val();
            const valueCell = row.find('td:nth-child(4)'); // Fourth column for value
            // Extract the index from the name attribute: conditions[123][type] -> 123
            const nameAttr = row.find('.condition-type').attr('name');
            const index = nameAttr.match(/\[(\d+)\]/)[1];
            const currentName = `conditions[${index}][value]`;

            let inputHtml = '';
            let selectedValues = [];

            if (initialValue !== null && initialValue !== undefined) {
                if (Array.isArray(initialValue)) {
                    selectedValues = initialValue.map(String);
                } else {
                    selectedValues = [String(initialValue)];
                }
            }
            
            // Clear previous input
            valueCell.empty();

            switch (type) {
                case 'has_star':
                case 'has_not_star':
                    inputHtml = `<select class="form-control form-control-sm condition-value" name="${currentName}">`;
                    inputHtml += `<option value="">-- Chọn Sao --</option>`;
                    ALL_STARS.forEach(star => {
                        const selected = selectedValues.includes(String(star.name)) ? 'selected' : '';
                        inputHtml += `<option value="${star.name}" ${selected}>${star.name}</option>`;
                    });
                    inputHtml += `</select>`;
                    break;
                case 'has_any_star':
                case 'has_not_any_star':
                case 'has_star_pair':
                case 'has_not_star_pair':
                    // Check if Select2 is available, otherwise use standard multiple select
                    inputHtml = `<select class="form-control form-control-sm condition-value select2-multiple" name="${currentName}[]" multiple="multiple">`;
                    ALL_STARS.forEach(star => {
                        const selected = selectedValues.includes(String(star.name)) ? 'selected' : '';
                        inputHtml += `<option value="${star.name}" ${selected}>${star.name}</option>`;
                    });
                    inputHtml += `</select>`;
                    break;
                case 'house_element':
                    inputHtml = `<select class="form-control form-control-sm condition-value" name="${currentName}">`;
                    inputHtml += `<option value="">-- Chọn Ngũ hành --</option>`;
                    ['Kim', 'Mộc', 'Thủy', 'Hỏa', 'Thổ'].forEach(element => {
                        const selected = selectedValues.includes(String(element)) ? 'selected' : '';
                        inputHtml += `<option value="${element}" ${selected}>${element}</option>`;
                    });
                    inputHtml += `</select>`;
                    break;
                case 'am_duong':
                    inputHtml = `<select class="form-control form-control-sm condition-value" name="${currentName}">`;
                    inputHtml += `<option value="">-- Chọn Âm/Dương --</option>`;
                    ['Âm', 'Dương'].forEach(val => {
                        const selected = selectedValues.includes(String(val)) ? 'selected' : '';
                        inputHtml += `<option value="${val}" ${selected}>${val}</option>`;
                    });
                    inputHtml += `</select>`;
                    break;
                case 'can_chi_year':
                case 'can_chi_month':
                case 'can_chi_day':
                case 'can_chi_hour':
                    if (operator === 'IN' || operator === 'NOT_IN') {
                         inputHtml = `<textarea class="form-control form-control-sm condition-value" name="${currentName}" placeholder="Danh sách Can Chi, phân cách dấu phẩy"></textarea>`;
                         // We need to set val() after creating element for textarea to handle special chars properly
                    } else {
                        inputHtml = `<input type="text" class="form-control form-control-sm condition-value" name="${currentName}" placeholder="VD: Giáp Tý" value="">`;
                    }
                    break;
                case 'custom':
                    inputHtml = `<textarea class="form-control form-control-sm condition-value" name="${currentName}" placeholder="Nhập JSON" rows="1"></textarea>`;
                    break;
                case 'age_at_view':
                    inputHtml = `<input type="number" class="form-control form-control-sm condition-value" name="${currentName}" placeholder="Tuổi" value="">`;
                    break;
                default:
                    inputHtml = `<input type="text" class="form-control form-control-sm condition-value" name="${currentName}" placeholder="Giá trị" value="">`;
                    break;
            }
            
            const $input = $(inputHtml);
            
            // Set value for non-select inputs (selects are handled by 'selected' attribute above)
            if (type === 'can_chi_year' || type === 'can_chi_month' || type === 'can_chi_day' || type === 'can_chi_hour') {
                 if (operator === 'IN' || operator === 'NOT_IN') {
                     $input.val(selectedValues.join(', '));
                 } else {
                     $input.val(selectedValues[0] || '');
                 }
            } else if (type === 'custom') {
                 if (initialValue) $input.val(JSON.stringify(initialValue));
            } else if (!inputHtml.startsWith('<select')) {
                 $input.val(selectedValues[0] || '');
            }

            valueCell.append($input);

            // Re-initialize select2 if available and needed
            if ($input.hasClass('select2-multiple') && $.fn.select2) {
                $input.select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Chọn các sao",
                    allowClear: true
                });
            }
        }
    });
</script>
@endpush
