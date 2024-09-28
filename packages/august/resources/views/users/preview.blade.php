@extends('August::layouts.app')
@section('page-title')
{{ trans('August::users.new_user') }}
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.users.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $arParams['ID'] }}">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::users.settings') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.name') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['USER']) && !empty($arParams['USER']->name)) {
                                                    $name = $arParams['USER']->name;
                                                } else {
                                                    $name = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="name" value="{{ $name }}" name="name" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.first_name') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['USER_META']) && !empty($arParams['USER_META']->first_name)) {
                                                    $first_name = $arParams['USER_META']->first_name;
                                                } else {
                                                    $first_name = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="first_name" value="{{ $first_name }}" name="first_name" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.last_name') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['USER_META']) && !empty($arParams['USER_META']->last_name)) {
                                                    $last_name = $arParams['USER_META']->last_name;
                                                } else {
                                                    $last_name = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="last_name" value="{{ $last_name }}" name="last_name" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.gender') }}</label>
                                            <div class="col-md-9 pt-1">
                                                @php
                                                if (isset($arParams['USER_META']) && !empty($arParams['USER_META']->gender)) {
                                                    $gender = $arParams['USER_META']->gender;
                                                } else {
                                                    $gender = '';
                                                }

                                                $checked = "";
                                                if ($gender == 1) {
                                                    $checked = "checked";
                                                }
                                                @endphp
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="gender_male" value="1" name="gender" {{ $checked }}>
                                                    <label class="form-check-label" for="gender_male">{{ trans('August::users.male') }}</label>
                                                </div>
                                                @php
                                                $checked = "";
                                                if ($gender == 0) {
                                                    $checked = "checked";
                                                }
                                                @endphp
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="gender_female" value="0" name="gender" {{ $checked }}>
                                                    <label class="form-check-label" for="gender_female">{{ trans('August::users.female') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.photo') }}</label>
                                            <div class="col-md-9">
                                            @php 
                                                if(isset($arParams['USER_FILE']) && !empty($arParams['USER_FILE']->path)) {
                                                $path = $arParams['USER_FILE']->path;
                                            @endphp
                                                <img class="img-fluid avatar-xl rounded-circle mb-1" src="{{ asset('storage/' . $path) }}" alt="{{ $path }}"/>
                                            @php
                                                }
                                            @endphp
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.birthday') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['USER_META']) && !empty($arParams['USER_META']->birthday)) {
                                                    $birthday = $arParams['USER_META']->birthday;
                                                } else {
                                                    $birthday = '';
                                                }
                                                @endphp
                                                <input type="date" class="form-control" id="birthday" value="{{ $birthday }}" name="birthday" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.email') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['USER']) && !empty($arParams['USER']->email)) {
                                                    $email = $arParams['USER']->email;
                                                } else {
                                                    $email = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="email" value="{{ $email }}" name="email" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.phone') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['USER_META']) && !empty($arParams['USER_META']->phone)) {
                                                    $phone = $arParams['USER_META']->phone;
                                                } else {
                                                    $phone = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="phone" value="{{ $phone }}" name="phone" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.password') }}</label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" id="password" value="" name="password">
                                            </div>
                                        </div>


                                        <!-- User Role -->
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::users.role') }}</label>

                                            <div class="col-md-9">
                                                <select class="js-example-basic-multiple" name="roles[]" multiple="multiple">
                                                    @php
                                                    $roleRelation = array();
                                                    if (isset($arParams['RELATION'])) {
                                                        foreach($arParams['RELATION'] as $relation) {
                                                            $roleRelation[$relation->role_id] = true;
                                                        }
                                                    }
                                                    
                                                    foreach ($arParams['ROLE'] as $role) {
                                                        $selected = "";
                                                        if (isset($roleRelation[$role->id])) {
                                                            $selected = "selected";
                                                        }
                                                        
                                                        @endphp 
                                                        <option value="{{ $role->id }}" {{ $selected }}>{{ $role->name }}</option>
                                                        @php
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@endsection

@push('js')
<script>
    (function ($) {
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    })(jQuery)
</script>
@endpush