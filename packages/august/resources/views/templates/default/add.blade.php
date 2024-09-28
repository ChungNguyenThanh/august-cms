@extends('August::layouts.app')

@section('page-title')
    {{ trans('August::element.add_new') }}
@endsection

@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.lists.index', ['id_block' => $arResults['ABLOCK_ID']]) }}" class="btn btn-secondary">{{ trans('August::element.back_to_list') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.lists.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_block" value="{{ $arResults['ABLOCK_ID'] }}">
                    <input type="hidden" name="id_element" value="{{ $arResults['ELEMENT_ID'] }}">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::element.info') }}</button>
                            <button class="nav-link" id="nav-access-tab" data-bs-toggle="tab" data-bs-target="#nav-access" type="button" role="tab" aria-controls="nav-access" aria-selected="false">{{ trans('August::ablock.access') }}</button>
                        </div>
                    </nav>
                    
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2 mobile-p-0">
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
                                                    <label class="col-md-3 col-form-label text-end mobile-text-start" for="{{ $userField['field_name'] }}">{{ $userField['edit_form_label'] }}</label>
                                                    <div class="col-md-9">
                                                        @php
                                                        if ($userField['user_type_id'] == 'string') {
                                                            @endphp
                                                            @include('August::widgets.string', ["userField" => $userField, "value" => $fieldValue])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'int') {
                                                            @endphp
                                                            @include('August::widgets.integer', ["userField" => $userField, "value" => $fieldValue])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'enum') {
                                                            @endphp
                                                            @include('August::widgets.enum', ["userField" => $userField, "value" => $fieldValue, "listEnum" => $userField['list_enum']
                                                            ])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'date') {
                                                            @endphp
                                                            @include('August::widgets.date', ["userField" => $userField, "value" => $fieldValue])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'datetime') {
                                                            @endphp
                                                            @include('August::widgets.datetime', ["userField" => $userField, "value" => $fieldValue])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'link_to_user') {
                                                            @endphp
                                                            @include('August::widgets.link_to_user', ["userField" => $userField, "value" => $fieldValue, "arUsers" => $arResults['USERS']])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'link_to_element') {
                                                            @endphp
                                                            @if($arResults['ELEMENT_ID'] == 0)
                                                            @include('August::widgets.link_to_element', ["userField" => $userField, "value" => $fieldValue])
                                                            @else
                                                            @include('August::widgets.link_to_element', ["userField" => $userField, "value" => $fieldValue, "element" => $arResults['ELEMENT']])
                                                            @endif
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'html') {
                                                            @endphp
                                                            @include('August::widgets.html', ["userField" => $userField, "value" => $fieldValue])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'file') {
                                                            @endphp
                                                            @include('August::widgets.file', ["userField" => $userField, "value" => $fieldValue])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'phone') {
                                                            @endphp
                                                            @include('August::widgets.phone', ["userField" => $userField, "value" => $fieldValue])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'link') {
                                                            @endphp 
                                                            @include('August::widgets.link', ["userField" => $userField, "value" => $fieldValue])
                                                            @php
                                                        } elseif ($userField['user_type_id'] == 'money') {
                                                            @endphp 
                                                            @include('August::widgets.money', ["userField" => $userField, "value" => $fieldValue])
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
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-access" role="tabpanel" aria-labelledby="nav-access-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2 mobile-p-0 list-access">
                                        @php
                                        $ind = 0;
                                        if ($arResults['RIGHT']) {
                                            foreach ($arResults['RIGHT'] as $right) {
                                                @endphp
                                                <div class="mb-2 row item-right">
                                                    <input type="hidden" name="entity_access[{{ $ind }}][user_id]" value="{{ $right['user_id'] }}">
                                                    <input type="hidden" name="entity_access[{{ $ind }}][access_code]" value="{{ $right['access_code'] }}">
                                                    <input type="hidden" name="entity_access[{{ $ind }}][provider_id]" value="{{ $right['provider_id'] }}">
                                                    <label class="col-md-3 col-form-label text-end mobile-text-start" for="example-color">{{ $right["obj_name"] }}</label>
                                                    <div class="col-md-9">
                                                        <div class="d-flex gap-1 mb-1">
                                                            <select class="form-control" name="entity_access[{{ $ind }}][access]">
                                                                @php
                                                                foreach ($arResults['TASK'] as $kTask => $vTask) {
                                                                    if ($right['letter'] == $kTask) {
                                                                        $select = 'selected';
                                                                    } else {
                                                                        $select = '';
                                                                    }
                                                                    @endphp
                                                                    <option {{ $select }} value="{{ $kTask }}">{{ $vTask }}</option>
                                                                    @php
                                                                }
                                                                @endphp
                                                            </select>
                                                            <span class="btn btn-danger btn-delete-right">Xoá</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                $ind++;
                                            }
                                        }
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::userfield.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::userfield.btn_apply') }}</button>
                        <a type="button" class="btn btn-secondary" href="{{URL::previous()}}">{{ trans('August::userfield.btn_cancel') }}</a>
                        <span type="button" class="btn btn-secondary btn-access ms-1 d-none" data-bs-toggle="modal" data-bs-target="#access_modal">{{ trans('August::userfield.btn_add_access') }}</span>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@include('August::widgets.permission', ["arUser" => $arResults['USERS'], "arRole" => $arResults['ROLES'], "arTask" => $arResults['TASK']])

@endsection