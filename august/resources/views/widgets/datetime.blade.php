@php
if (isset($view) && ($view == 'list')) {
    $fieldValue = '';
    if (isset($value)) {
        $fieldValue = $value;
    }

    if ($userField['multiple'] == 'Y') {
        if (is_array($fieldValue)) {
            foreach ($fieldValue as $val) {
                echo date('d/m/Y H:i', strtotime($val))."<br>";
            }
        }
    } else {
        echo date('d/m/Y H:i', strtotime($fieldValue));
    }
} elseif (isset($view) && ($view == 'filter')) {
    $from = "";
    if (isset($value["FROM"])) {
        $from = $value["FROM"];
    }

    $to = "";
    if (isset($value["TO"])) {
        $to = $value["TO"];
    }
    @endphp
    <div class="d-flex gap-1 mt-1 align-items-center">
        <input type="datetime-local" id="{{ $userField['field_name'] }}[FROM]" name="{{ $userField['field_name'] }}[FROM]" value="{{ $from }}" class="form-control">
        <span>-</span>
        <input type="datetime-local" id="{{ $userField['field_name'] }}[TO]" name="{{ $userField['field_name'] }}[TO]" value="{{ $to }}" class="form-control">
    </div>
    @php
} else {
    $fieldValue = '';
    if (isset($value)) {
        $fieldValue = $value;
    }

    if ($userField['multiple'] == 'Y') {
        if (is_array($fieldValue)) {
            foreach ($fieldValue as $val) {
                @endphp
                <div class="d-flex gap-1 mb-1">
                    <input type="datetime-local" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}[]" value="{{ $val }}" class="form-control">
                    <span class="btn btn-danger btn-delete-input-datetime">Xoá</span>
                </div>
                @php
            }
        }
        @endphp
        <span class="btn btn-success btn-add-input-datetime" item-field-name="{{ $userField['field_name'] }}">Thêm</span>
        @php
    } else {
        @endphp
        <input type="datetime-local" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}" value="{{ $fieldValue }}" class="form-control">
        @php
    }
}
@endphp

@push('js')
<script src="/assets-august/js/widgets/august-datetime.js"></script>
@endpush
