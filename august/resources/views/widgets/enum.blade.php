@push('css')
<link href="/assets-august/css/widgets/august-enum.css" rel="stylesheet" type="text/css" />
@endpush

@php
if (isset($view) && ($view == 'list')) {
    if ($userField['multiple'] == 'Y') {
        foreach ($value as $val) {
            foreach ($listEnum as $enum) {
                if ($enum["id"] == $val) {
                    $showValue[] = $enum["value"];
                    break;
                }
            }
        }

        if (isset($showValue)) {
            echo implode("<br>", $showValue);
        } else {
            echo implode("<br>", $value);
        }
    } else {
        foreach ($listEnum as $enum) {
            if ($enum["id"] == $value) {
                $showValue = $enum["value"];
                break;
            }
        }

        if (isset($showValue)) {
            echo $showValue;
        } else {
            echo $value;
        }
    }
} elseif (isset($view) && ($view == 'filter')) {
    @endphp
    <select class="form-control" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}">
        <option value="">--</option>
        @php
        foreach ($listEnum as $enum) {
            if (!empty($value) && ($enum["id"] == $value)) {
                $select = 'selected';
            } else {
                $select = '';
            }
            @endphp
            <option {{ $select }} value="{{ $enum['id'] }}">{{ $enum["value"] }}</option>
            @php
        }
        @endphp
    </select>
    @php
} else {
    if ($userField['multiple'] == 'Y') {
        @endphp
        <select class="form-control enum-select-input" id="{{ $userField['field_name'] }}" multiple="multiple" name="{{ $userField['field_name'] }}[]">
            @php
            foreach ($listEnum as $enum) {
                if (!empty($value) && in_array($enum["id"], $value)) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
                @endphp
                <option {{ $select }} value="{{ $enum['id'] }}">{{ $enum["value"] }}</option>
                @php
            }
            @endphp
        </select>  
        @php
    } else {
        @endphp
        <select class="form-control" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}">
            @php
            foreach ($listEnum as $enum) {
                if (!empty($value) && ($enum["id"] == $value)) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
                @endphp
                <option {{ $select }} value="{{ $enum['id'] }}">{{ $enum["value"] }}</option>
                @php
            }
            @endphp
        </select>
        @php
    }
}
@endphp

@push('js')
<script src="/assets-august/js/widgets/august-enum.js"></script>
@endpush
