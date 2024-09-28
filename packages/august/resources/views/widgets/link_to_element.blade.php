@php
use Package\August\Http\Controllers\UtilityController;
@endphp

@push('css')
<link href="/assets-august/css/widgets/link-to-user.css" rel="stylesheet" type="text/css" />
<link href="/assets-august/css/widgets/link-to-element.css" rel="stylesheet" type="text/css" />
@endpush

@php
$setting = json_decode($userField['settings']);
$id_ablock = $setting->link_to_ablock;
$show_field = $setting->show_field;

if (isset($view) && ($view == 'list')) {
    if (!empty($value)) {
        if ($userField['multiple'] == 'Y') {
            foreach($value as $el) {
                @endphp
                <a href="{{ route('august.lists.preview', ['id_block' => $el['ablock_id'], 'id_element' => $el['element_id']]) }}" target="_blank">{{ $el["element_value"] }}</a><br>
                @php
            }
        } else {
            @endphp
            <a href="{{ route('august.lists.preview', ['id_block' => $value['ablock_id'], 'id_element' => $value['element_id']]) }}" target="_blank">{{ $value["element_value"] }}</a><br>
            @php
        }
    }
} else {
    @endphp
    <div class="form-control user-field" id="link_to_user_<?php echo $userField['field_name'] ?>">
        <span class="chooseuser gap-2" style="display: inline-flex;">
            @php
            if (isset($value) && !empty($value)) {
                if ($userField['multiple'] == 'Y') {
                    foreach($value as $el) {
                        @endphp
                        <span style="display: inline;">
                            <input type="hidden" name="{{ $userField['field_name'] }}[]" value="{{ $el['element_id'] }}">
                            <span class="us-name">{{ $el["element_value"] }} <span class="remove-usn" onclick="removeSelectElement('{{ $el['element_id'] }}', '{{ $userField['field_name'] }}', this)">x</span></span>
                        </span>
                        @php
                    }
                } else {
                    @endphp
                    <span style="display: inline;">
                        <input type="hidden" name="{{ $userField['field_name'] }}" value="{{ $value['element_id'] }}">
                        <span class="us-name">{{ $value["element_value"] }} <span class="remove-usn" onclick="removeSelectElement('{{ $value['element_id'] }}', '{{ $userField['field_name'] }}', this)">x</span></span>
                    </span>
                    @php
                }
            }
            @endphp
        </span>
        <input type="hidden" name="route_{{ $userField['field_name'] }}" value="{{ route('august.lists.get.elementlinkto') }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <span class="lua-chon" data-bs-toggle="modal" data-bs-target="#user-modal_<?php echo $userField['field_name'] ?>" onclick="showListElement('{{ $id_ablock }}', '{{ $userField['field_name'] }}', '{{ $show_field }}', '{{ $userField["multiple"] }}')">+ Lựa chọn</span>
    </div>
    <div id="user-modal_<?php echo $userField['field_name'] ?>" class="user-modal modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Danh sách Element</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-1">
                        <div class="input-group">
                            <input type="text" class="form-control border-0" placeholder="" aria-label="" id="search_<?php echo $userField['field_name'] ?>">
                            <button class="btn btn-dark waves-effect waves-light" onclick="searchElement('{{ $id_ablock }}', '{{ $userField['field_name'] }}', '{{ $show_field }}', '{{ $userField["multiple"] }}')" type="button">Search</button>
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                        <div class="w-80 table-element">
                        </div>
                        <div class="w-20">
                            <div class="card mb-0 p-1">
                                <div class="d-flex gap-1 flex-column mb-1 list-select-element">
                                </div>
                                <span class="btn btn-success" onclick="selectElements('{{ $userField['field_name'] }}', '{{ $userField["multiple"] }}');">Chọn</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
}
@endphp

@push('js')
<script src="/assets-august/js/widgets/link-to-element.js"></script>
@endpush