@extends('August::layouts.app')

@section('page-title')
    {{ trans('August::element.preview') }}
@endsection

@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.lists.index', ['id_block' => $arResults['ABLOCK_ID']]) }}" class="btn btn-secondary">{{ trans('August::element.back_to_list') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="p-2">
                            @php
                            foreach ($arResults['USER_FIELD'] as $userField) {
                                if (isset($arResults['ITEM'][$userField['field_name']]["value"])) {
                                    $fieldValue = $arResults['ITEM'][$userField['field_name']]["value"];
                                } else {
                                    $fieldValue = "";
                                }
                                if (($arResults['ELEMENT_ID'] == 0 && (empty($userField['show_add_form']) || isset($userField['show_add_form']) && $userField['show_add_form'] != 'Y')) || ($arResults['ELEMENT_ID'] != 0 && (empty($userField['show_edit_form']) || isset($userField['show_edit_form']) && $userField['show_edit_form'] != 'Y'))) {
                                    continue;
                                } else {
                                    @endphp
                                    <div class="mb-2 row">
                                        <label class="col-md-3 col-form-label text-end" for="{{ $userField['field_name'] }}">{{ $userField['edit_form_label'] }}</label>
                                        <div class="col-md-9 align-items-center d-flex">
                                            @php
                                            if ($userField['user_type_id'] == 'string') {
                                                @endphp
                                                @include('August::widgets.string', ["userField" => $userField, "value" => $fieldValue, "view" => 'list'])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'int') {
                                                @endphp
                                                @include('August::widgets.integer', ["userField" => $userField, "value" => $fieldValue, "view" => 'list'])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'enum') {
                                                @endphp
                                                @include('August::widgets.enum', ["userField" => $userField, "value" => $fieldValue, "listEnum" => $userField['list_enum'], "view" => 'list'
                                                ])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'date') {
                                                @endphp
                                                @include('August::widgets.date', ["userField" => $userField, "value" => $fieldValue, "view" => 'list'])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'datetime') {
                                                @endphp
                                                @include('August::widgets.datetime', ["userField" => $userField, "value" => $fieldValue, "view" => 'list'])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'link_to_user') {
                                                @endphp
                                                @include('August::widgets.link_to_user', ["userField" => $userField, "value" => $fieldValue, "arUsers" => $arResults['USERS'], "view" => 'list'])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'link_to_element') {
                                                @endphp
                                                @include('August::widgets.link_to_element', ["userField" => $userField, "value" => $fieldValue, "view" => 'list'])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'html') {
                                                @endphp
                                                @include('August::widgets.html', ["userField" => $userField, "value" => $fieldValue, "view" => 'list'])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'file') {
                                                @endphp
                                                @include('August::widgets.file', ["userField" => $userField, "value" => $fieldValue, "view" => 'list'])
                                                @php
                                            } elseif ($userField['user_type_id'] == 'float') {
                                                @endphp
                                                @include('August::widgets.float', ["userField" => $userField, "value" => $fieldValue, "view" => 'list'])
                                                @php
                                            } else {
                                                @endphp
                                                <input type="" class="form-control" id="{{ $userField['field_name'] }}" value="{{ $fieldValue }}" name="{{ $userField['field_name'] }}">
                                                @php
                                            }
                                            @endphp
                                        </div>
                                    </div>
                                    @php
                                }
                            }
                            @endphp
                        </div>
                    </div>
                </div><!-- end row -->
            </div>
        </div><!-- end card -->
    </div><!-- end col -->
</div>
@endsection