@extends('August::layouts.app')
@section('page-title')
    {{ trans('August::userfield.new_field') }}
@endsection
@section('content')


<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.userfield.index', ['id_block' => $arParams['ABLOCK_ID']]) }}" class="btn btn-secondary">{{ trans('August::userfield.back_to_list') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.userfield.store', ['id_block' => $arParams['ABLOCK_ID']]) }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $arParams['ID'] }}">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::userfield.settings') }}</button>
                            <button class="nav-link" id="nav-extra-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-extra-settings" type="button" role="tab" aria-controls="nav-extra-settings" aria-selected="false">{{ trans('August::userfield.extra_settings') }}</button>

                            @php
                            if (isset($arParams['USER_FIELD']->user_type_id) && $arParams['USER_FIELD']->user_type_id == 'enum') {
                                $display = '';
                            } else {
                                $display = 'display: none;';
                            }
                            @endphp
                            <button class="nav-link" id="nav-enum-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-enum-settings" type="button" role="tab" aria-controls="nav-enum-settings" aria-selected="false" style="{{ $display }}">{{ trans('August::userfield.enum_settings') }}</button>

                            <button class="nav-link" id="nav-language-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-language-settings" type="button" role="tab" aria-controls="nav-language-settings" aria-selected="false">{{ trans('August::userfield.language_settings') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.type') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if ($arParams['ID'] != 0) {
                                                    @endphp
                                                    <input type="hidden" class="form-control" value="{{ $arParams['USER_FIELD']->user_type_id }}" name="user_type_id">
                                                    <span>{{ $arParams['USER_FIELD_TYPE'][$arParams['USER_FIELD']->user_type_id] }}</span>
                                                    @php
                                                } else {
                                                    @endphp
                                                    <select class="form-control" name="user_type_id">
                                                        @foreach($arParams['USER_FIELD_TYPE'] as $key => $value)
                                                            @php
                                                            if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->user_type_id) && ($key == $arParams['USER_FIELD']->user_type_id)) {
                                                                $select = 'selected';
                                                            } else {
                                                                $select = '';
                                                            }
                                                            @endphp
                                                            <option {{ $select }} value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    @php
                                                }
                                                @endphp
                                                
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <input type="hidden" class="form-control" value="{{ $arParams['ABLOCK_ID'] }}" name="ablock_id">
                                            <input type="hidden" class="form-control" value="{{ $arParams['ABLOCK_CODE'] }}" name="entity_id">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.entity') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                <span>{{ $arParams["ABLOCK_CODE"] }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.field_id_only_new') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->field_name)) {
                                                    $fieldName = $arParams['USER_FIELD']->field_name;
                                                } else {
                                                    $fieldName = '';
                                                }

                                                if ($arParams['ID'] != 0) {
                                                    @endphp
                                                    <input type="hidden" class="form-control" id="field_id_only_new" value="{{ $fieldName }}" name="field_name">
                                                    <span>{{ $fieldName }}</span>
                                                    @php
                                                } else {
                                                    @endphp
                                                    <input type="" class="form-control" id="field_id_only_new" value="{{ $fieldName }}" name="field_name">
                                                    @php
                                                }

                                                @endphp

                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.xml_id') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->xml_id)) {
                                                    $xmlId = $arParams['USER_FIELD']->xml_id;
                                                } else {
                                                    $xmlId = '';
                                                }

                                                if ($arParams['ID'] != 0) {
                                                    @endphp
                                                    <input type="hidden" class="form-control" id="xml_id" value="{{ $xmlId }}" name="xml_id">
                                                    <span>{{ $xmlId }}</span>
                                                    @php
                                                } else {
                                                    @endphp
                                                    <input type="" class="form-control" id="xml_id" value="{{ $xmlId }}" name="xml_id">
                                                    @php
                                                }
                                                @endphp
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.sorting') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->sort)) {
                                                    $sort = $arParams['USER_FIELD']->sort;
                                                } else {
                                                    $sort = 100;
                                                }
                                                @endphp
                                                <input type="number" class="form-control" id="sorting" value="{{ $sort }}" name="sort">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.multiple_id_only_new') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->multiple) && ($arParams['USER_FIELD']->multiple) == 'Y') {
                                                    $check = 'checked';
                                                    $multiple = $arParams['USER_FIELD']->multiple;
                                                } else {
                                                    $check = '';
                                                    $multiple = 'N';
                                                }

                                                if ($arParams['ID'] != 0) {
                                                    $disable = 'disabled';
                                                } else {
                                                    $disable = '';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $multiple }}" id="multiple" name="multiple">
                                                <input class="form-check-input" type="checkbox" {{ $check }} onclick="oncheckbox('multiple', this, 'Y', 'N')" {{ $disable }}>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.required') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->mandatory) && ($arParams['USER_FIELD']->mandatory) == 'Y') {
                                                    $check = 'checked';
                                                    $mandatory = $arParams['USER_FIELD']->mandatory;
                                                } else {
                                                    $check = '';
                                                    $mandatory = 'N';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $mandatory }}" id="mandatory" name="mandatory">
                                                <input class="form-check-input" type="checkbox" {{ $check }} onclick="oncheckbox('mandatory', this, 'Y', 'N')">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.display_in_filter') }}</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="show_filter">
                                                    @php
                                                    if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->show_filter) && ($arParams['USER_FIELD']->show_filter) == 'N') {
                                                        $select = 'selected';
                                                    } else {
                                                        $select = '';
                                                    }
                                                    @endphp
                                                    <option {{ $select }} value="N">{{ trans('August::userfield.never') }}</option>
                                                    @php
                                                    if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->show_filter) && ($arParams['USER_FIELD']->show_filter) == 'I') {
                                                        $select = 'selected';
                                                    } else {
                                                        $select = '';
                                                    }
                                                    @endphp
                                                    <option {{ $select }} value="I">{{ trans('August::userfield.exact_match') }}</option>
                                                    @php
                                                    if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->show_filter) && ($arParams['USER_FIELD']->show_filter) == 'E') {
                                                        $select = 'selected';
                                                    } else {
                                                        $select = '';
                                                    }
                                                    @endphp
                                                    <option {{ $select }} value="E">{{ trans('August::userfield.wildcard_search') }}</option>
                                                    @php
                                                    if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->show_filter) && ($arParams['USER_FIELD']->show_filter) == 'S') {
                                                        $select = 'selected';
                                                    } else {
                                                        $select = '';
                                                    }
                                                    @endphp
                                                    <option {{ $select }} value="S">{{ trans('August::userfield.partial_match') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.dont_display_in_lists') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->show_in_list) && ($arParams['USER_FIELD']->show_in_list) == 'N') {
                                                    $check = 'checked';
                                                    $showInList = 'N';
                                                } else {
                                                    $check = '';
                                                    $showInList = 'Y';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $showInList }}" id="show_in_list" name="show_in_list">
                                                <input class="form-check-input" type="checkbox" {{ $check }} onclick="oncheckbox('show_in_list', this, 'N', 'Y')">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.read_only') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->edit_in_list) && ($arParams['USER_FIELD']->edit_in_list) == 'N') {
                                                    $check = 'checked';
                                                    $edit_in_list = 'N';
                                                } else {
                                                    $check = '';
                                                    $edit_in_list = 'Y';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $edit_in_list }}" id="edit_in_list" name="edit_in_list">
                                                <input class="form-check-input" type="checkbox" onclick="oncheckbox('edit_in_list', this, 'N', 'Y')" {{ $check }}>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.show_in_new_item_form') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->show_add_form) && ($arParams['USER_FIELD']->show_add_form) == 'N') {
                                                    $check = '';
                                                    $show_add_form = 'N';
                                                } else {
                                                    $check = 'checked';
                                                    $show_add_form = 'Y';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $show_add_form }}" id="show_add_form" name="show_add_form">
                                                <input class="form-check-input" type="checkbox" onclick="oncheckbox('show_add_form', this, 'Y', 'N')" {{ $check }}>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.show_in_edit_item_form') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->show_edit_form) && ($arParams['USER_FIELD']->show_edit_form) == 'N') {
                                                    $check = '';
                                                    $show_edit_form = 'N';
                                                } else {
                                                    $check = 'checked';
                                                    $show_edit_form = 'Y';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $show_edit_form }}" id="show_edit_form" name="show_edit_form">
                                                <input class="form-check-input" type="checkbox" onclick="oncheckbox('show_edit_form', this, 'Y', 'N')" {{ $check }}>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.read_only_in_new_item_form') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->add_read_only_field) && ($arParams['USER_FIELD']->add_read_only_field) == 'Y') {
                                                    $check = 'checked';
                                                    $add_read_only_field = 'Y';
                                                } else {
                                                    $check = '';
                                                    $add_read_only_field = 'N';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $add_read_only_field }}" id="add_read_only_field" name="add_read_only_field">
                                                <input class="form-check-input" type="checkbox" onclick="oncheckbox('add_read_only_field', this, 'Y', 'N')" {{ $check }}>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.read_only_in_edit_item_form') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->edit_read_only_field) && ($arParams['USER_FIELD']->edit_read_only_field) == 'Y') {
                                                    $check = 'checked';
                                                    $edit_read_only_field = 'Y';
                                                } else {
                                                    $check = '';
                                                    $edit_read_only_field = 'N';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $edit_read_only_field }}" id="edit_read_only_field" name="edit_read_only_field">
                                                <input class="form-check-input" type="checkbox" onclick="oncheckbox('edit_read_only_field', this, 'Y', 'N')" {{ $check }}>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.show_field_preview') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->show_field_preview) && ($arParams['USER_FIELD']->show_field_preview) == 'Y') {
                                                    $check = 'checked';
                                                    $show_field_preview = 'Y';
                                                } else {
                                                    $check = '';
                                                    $show_field_preview = 'N';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $show_field_preview }}" id="show_field_preview" name="show_field_preview">
                                                <input class="form-check-input" type="checkbox" onclick="oncheckbox('show_field_preview', this, 'Y', 'N')" {{ $check }}>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="is_searchable">{{ trans('August::userfield.is_searchable') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->is_searchable) && ($arParams['USER_FIELD']->is_searchable) == 'Y') {
                                                    $check = 'checked';
                                                    $is_searchable = 'Y';
                                                } else {
                                                    $check = '';
                                                    $is_searchable = 'N';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $is_searchable }}" id="is_searchable" name="is_searchable">
                                                <input class="form-check-input" type="checkbox" onclick="oncheckbox('is_searchable', this, 'Y', 'N')" {{ $check }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-extra-settings" role="tabpanel" aria-labelledby="nav-extra-settings-tab">
                            @php
                            if (isset($arParams['USER_FIELD']) && !empty($arParams['USER_FIELD']->settings)) {
                                $settings = json_decode($arParams['USER_FIELD']->settings);
                            }
                            @endphp
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="example-time">{{ trans('August::userfield.default_value') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (isset($settings) && !empty($settings->default_value)) {
                                                    $default_value = $settings->default_value;
                                                } else {
                                                    $default_value = '';
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="default_value" value="{{ $default_value }}" name="settings[default_value]">
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="example-week">{{ trans('August::userfield.input_field_size') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (isset($settings) && !empty($settings->size)) {
                                                    $size = $settings->size;
                                                } else {
                                                    $size = 20;
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="input_field_size" value="{{ $size }}" name="settings[size]">
                                            </div>
                                        </div>

                                        <!-- Input Link to Element -->
                                        @php
                                        if(isset($arParams['USER_FIELD']) && $arParams['USER_FIELD']->user_type_id == 'link_to_element') {
                                            $style = '';
                                        } else {
                                            $style = 'd-none';
                                        }
                                        @endphp
                                        <div class="mb-2 row {{ $style }}" id="link_to_ablock">
                                            <label class="col-md-3 col-form-label text-end" for="example-number">{{ trans('August::userfield.link_to_ablock') }}</label>
                                            <div class="col-md-9">
                                                @include('August::widgets.link_to_ablock', ["name" => 'link_to_ablock'])
                                            </div>
                                        </div>
                                        @php 
                                        if (isset($arParams['SETTINGS']) && !empty($settings->show_field)) {
                                            @endphp 
                                            <div class="mb-2 row" id="show_field">
                                                <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.show_column') }}</label>
                                                <div class="col-md-9 align-items-center d-flex">
                                                    <select class="form-control" name="settings[show_field]">
                                                    @php
                                                    foreach($arParams['LIST_FIELD'] as $field) {
                                                        @endphp
                                                        <option value="{{ $field->field_name }}" {{ $settings->show_field == $field->field_name ? 'selected' : '' }}>{{ $field->edit_form_label ? $field->edit_form_label : $field->field_name }}</option>
                                                        @php
                                                    }
                                                    @endphp
                                                    </select>
                                                </div>
                                            </div>
                                            @php
                                        }
                                        @endphp

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="example-number">{{ trans('August::userfield.row_count') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (isset($settings) && !empty($settings->rows)) {
                                                    $rows = $settings->rows;
                                                } else {
                                                    $rows = 1;
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="row_count" value="{{ $rows }}" name="settings[rows]">
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.minimum_length') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (isset($settings) && !empty($settings->min_length)) {
                                                    $min_length = $settings->min_length;
                                                } else {
                                                    $min_length = 0;
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="minimum_length" value="{{ $min_length }}" name="settings[min_length]">
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.maximum_length') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (isset($settings) && !empty($settings->max_length)) {
                                                    $max_length = $settings->max_length;
                                                } else {
                                                    $max_length = 0;
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="maximum_length" value="{{ $max_length }}" name="settings[max_length]">
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.validation_regular_expression') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (isset($settings) && !empty($settings->regexp)) {
                                                    $regexp = $settings->regexp;
                                                } else {
                                                    $regexp = '';
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="validation_regular_expression" value="{{ $regexp }}" name="settings[regexp]">
                                            </div>
                                        </div>
                                        <!-- unit for field money -->
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.unit_money') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (isset($settings) && !empty($settings->unit_money)) {
                                                    $unit_money = $settings->unit_money;
                                                } else {
                                                    $unit_money = '';
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="unit_money" value="{{ $unit_money }}" name="settings[unit_money]">
                                            </div>
                                        </div>
                                        <!-- add to fulltextsearch -->
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfield.full_text_search') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php
                                                if (isset($settings) && !empty($settings->full_text_search)) {
                                                    $check = 'checked';
                                                    $full_text_search = 'Y';
                                                } else {
                                                    $check = '';
                                                    $full_text_search = 'N';
                                                }
                                                @endphp
                                                <input type="hidden" value="{{ $full_text_search }}" id="full_text_search" name="settings[full_text_search]">
                                                <input class="form-check-input" type="checkbox" onclick="oncheckbox('full_text_search', this, 'Y', 'N')" {{ $check }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-enum-settings" role="tabpanel" aria-labelledby="nav-enum-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">{{ trans('August::userfield.xml_id') }}</th>
                                                <th class="align-middle">{{ trans('August::userfield.value') }}</th>
                                                <th class="align-middle">{{ trans('August::userfield.sort') }}</th>
                                                <th class="align-middle">{{ trans('August::userfield.default') }}</th>
                                                <th class="align-middle">
                                                    @php
                                                    if (isset($arParams['USER_FIELD_ENUM'])) {
                                                        $countEnum = count($arParams['USER_FIELD_ENUM']);
                                                    } else {
                                                        $countEnum = 1;
                                                    }
                                                    @endphp
                                                    <button type="button" number-item-row-enum="{{ $countEnum }}" id="add-row-enum" class="btn btn-link">{{ trans('August::messages.add_row') }}</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($arParams['USER_FIELD_ENUM']) && !empty($arParams['USER_FIELD_ENUM']))
                                                @php
                                                $ind = 0;
                                                @endphp
                                                @foreach($arParams['USER_FIELD_ENUM'] as $item)
                                                    <tr>
                                                        <input type="hidden" name="enum_settings[index][]" value="{{ $ind }}">
                                                        <td class="align-middle">
                                                            <input type="" class="form-control" id="enum_xml_id" value="{{ $item->xml_id }}" name="enum_settings[xml_id][]">
                                                        </td>
                                                        <td class="align-middle">
                                                            <input type="" class="form-control" id="enum_value" value="{{ $item->value }}" name="enum_settings[value][]">
                                                        </td>
                                                        <td class="align-middle">
                                                            <input type="" class="form-control" id="enum_sort" value="{{ $item->sort }}" name="enum_settings[sort][]">
                                                        </td>
                                                        <td class="align-middle">
                                                            <input type="radio" class="form-check-input" id="enum_default" value="{{ $ind }}" name="enum_settings[default][]" {{$item->def == 1 ? 'checked' : ''}}>
                                                        </td>
                                                        <td class="align-middle">
                                                            <button type="button" class="btn btn-link remove-row-enum">{{ trans('August::messages.delete') }}</button>
                                                        </td>
                                                    </tr>
                                                    @php
                                                    $ind++;
                                                    @endphp
                                                @endforeach
                                            @else
                                                <tr>
                                                    <input type="hidden" name="enum_settings[index][]" value="0">
                                                    <td class="align-middle">
                                                        <input type="" class="form-control" id="enum_xml_id" name="enum_settings[xml_id][]">
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="" class="form-control" id="enum_value" name="enum_settings[value][]">
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="" class="form-control" id="enum_sort" value="100" name="enum_settings[sort][]">
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="radio" class="form-check-input" id="enum_default" value="0" name="enum_settings[default][]">
                                                    </td>
                                                    <td class="align-middle">
                                                        <button type="button" class="btn btn-link remove-row-enum">{{ trans('August::messages.delete') }}</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- nav-enum-settings -->

                        <div class="tab-pane fade" id="nav-language-settings" role="tabpanel" aria-labelledby="nav-language-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">{{ trans('August::language.en') }}</div>
                                        <div class="card-body">
                                            <div class="p-2">
                                                @php
                                                $edit_form_label_en = '';
                                                $list_column_label_en = '';
                                                $list_filter_label_en = '';
                                                $error_message_label_en = '';
                                                $help_message_label_en = '';
                                                $edit_form_label_vi = '';
                                                $list_column_label_vi = '';
                                                $list_filter_label_vi = '';
                                                $error_message_label_vi = '';
                                                $help_message_label_vi = '';
                                                if(isset($arParams['USER_FIELD_LANG']) && !empty($arParams['USER_FIELD_LANG'])) {
                                                    foreach($arParams['USER_FIELD_LANG'] as $key => $value) {
                                                        if($value['lang_id'] == 'en') {
                                                            $edit_form_label_en = $value['edit_form_label'];
                                                            $list_column_label_en = $value['list_column_label'];
                                                            $list_filter_label_en = $value['list_filter_label'];
                                                            $error_message_label_en = $value['error_message_label'];
                                                            $help_message_label_en = $value['help_message_label'];
                                                        }
                                                        if($value['lang_id'] == 'vi') {
                                                            $edit_form_label_vi = $value['edit_form_label'];
                                                            $list_column_label_vi = $value['list_column_label'];
                                                            $list_filter_label_vi = $value['list_filter_label'];
                                                            $error_message_label_vi = $value['error_message_label'];
                                                            $help_message_label_vi = $value['help_message_label'];
                                                        }
                                                    }
                                                }
                                                @endphp
                                                <div class="mb-2 row">
                                                    <label class="col-md-3 col-form-label text-end" for="example-color">{{ trans('August::userfield.label_in_editing_forms') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="" class="form-control" value="{{ $edit_form_label_en }}" name="lang[en][edit_form_label]">
                                                    </div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <label class="col-md-3 col-form-label text-end" for="form-range">{{ trans('August::userfield.column_header') }}</label>
                                                    <div class="col-md-9 align-self-center">
                                                        <input type="" class="form-control" value="{{ $list_column_label_en }}" name="lang[en][list_column_label]">
                                                    </div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <label for="exampleDataList" class="col-md-3 col-form-label text-end">{{ trans('August::userfield.filter_label') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="" class="form-control" value="{{ $list_filter_label_en }}" name="lang[en][list_filter_label]">
                                                    </div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <label for="exampleDataList" class="col-md-3 col-form-label text-end">{{ trans('August::userfield.error_message') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="" class="form-control" value="{{ $error_message_label_en }}" name="lang[en][error_message_label]">
                                                    </div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <label for="exampleDataList" class="col-md-3 col-form-label text-end">{{ trans('August::userfield.help') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="" class="form-control" value="{{ $help_message_label_en }}" name="lang[en][help_message_label]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">{{ trans('August::language.vi') }}</div>
                                        <div class="card-body">
                                            <div class="p-2">

                                                <div class="mb-2 row">
                                                    <label class="col-md-3 col-form-label text-end" for="example-color">{{ trans('August::userfield.label_in_editing_forms') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="" class="form-control" value="{{ $edit_form_label_vi }}" name="lang[vi][edit_form_label]">
                                                    </div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <label class="col-md-3 col-form-label text-end" for="form-range">{{ trans('August::userfield.column_header') }}</label>
                                                    <div class="col-md-9 align-self-center">
                                                        <input type="" class="form-control" value="{{ $list_column_label_vi }}" name="lang[vi][list_column_label]">
                                                    </div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <label for="exampleDataList" class="col-md-3 col-form-label text-end">{{ trans('August::userfield.filter_label') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="" class="form-control" value="{{ $list_filter_label_vi }}" name="lang[vi][list_filter_label]">
                                                    </div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <label for="exampleDataList" class="col-md-3 col-form-label text-end">{{ trans('August::userfield.error_message') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="" class="form-control" value="{{ $error_message_label_vi }}" name="lang[vi][error_message_label]">
                                                    </div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <label for="exampleDataList" class="col-md-3 col-form-label text-end">{{ trans('August::userfield.help') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="" class="form-control" value="{{ $help_message_label_vi }}" name="lang[vi][help_message_label]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::userfield.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::userfield.btn_apply') }}</button>
                        <button type="button" class="btn btn-secondary">{{ trans('August::userfield.btn_cancel') }}</button>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@endsection

@push('js')
<script src="/assets-august/js/widgets/link-to-ablock.js"></script>
@endpush

@push('js')
<script>
    function oncheckbox(id, dom, val1, val2) {
        if ($(dom).is(':checked')) {
            $("#" + id).val(val1);
        } else {
            $("#" + id).val(val2);
        }
    }

    (function ($) {
        $(document).on("change", "select[name='user_type_id']", function() {
            let type = $(this).val();
            if (type == 'enum') {
                $("#nav-enum-settings-tab").css('display', 'inline');
            } else {
                $("#nav-enum-settings-tab").css('display', 'none');

            }
        });



        $(document).on("click", "#nav-enum-settings #add-row-enum", function() {
            let countItem = parseInt($(this).attr('number-item-row-enum'));

            let mark = `
            <tr>
                <input type="hidden" name="enum_settings[index][]" value="`+countItem+`">
                <td class="align-middle">
                    <input type="" class="form-control" id="enum_xml_id" value="" name="enum_settings[xml_id][]">
                </td>
                <td class="align-middle">
                    <input type="" class="form-control" id="enum_value" value="" name="enum_settings[value][]">
                </td>
                <td class="align-middle">
                    <input type="" class="form-control" id="enum_sort" value="100" name="enum_settings[sort][]">
                </td>
                <td class="align-middle">
                    <input type="radio" class="form-check-input" id="enum_default" value="`+countItem+`" name="enum_settings[default][]">
                </td>
                <td class="align-middle">
                    <button type="button" class="btn btn-link remove-row-enum">{{ trans('August::messages.delete') }}</button>
                </td>
            </tr>
            `;
            $("#nav-enum-settings tbody").append(mark);

            countItem ++;
            $(this).attr('number-item-row-enum', countItem);
        });

        $(document).on("click", "#nav-enum-settings .remove-row-enum", function() {
        	$(this).parent().parent().remove();
        });
    })(jQuery)
</script>
@endpush
