@push('css')
<link href="/assets-august/css/widgets/august-filter.css" rel="stylesheet" type="text/css" />
@endpush

<form class="august-search" action="{{ url()->current() }}" method="post" id="august_search">
    @csrf
    @php
    if (isset($limit)) {
        @endphp
        <input type="hidden" name="limit" value="{{ $limit }}">
        @php
    }
    @endphp
    <div class="app-search-box dropdown">
        <div class="input-group border border-1 rounded-3">
            @php
            $val = null;
            if (isset($filterMode["FULL_TEXT_SEARCH"])) {
                $val = $filterMode["FULL_TEXT_SEARCH"];
            }
            @endphp
            <input type="search" class="form-control border-0" name="filter_mode[FULL_TEXT_SEARCH]" value="{{ $val }}" placeholder="Search..." id="august-top-search">
            <button class="btn bg-white" type="submit">
                <i class="fe-search"></i>
            </button>
        </div>
        <div class="dropdown-menu p-0 w-100" id="august-search-dropdown">
            <div class="d-flex w-100">
                <div class="bg-light d-flex flex-column p-2 w-30 flex-fill">
                    <div class="border-bottom text-center">Bộ lọc</div>
                </div>
                <div class="p-2 w-70 flex-fill">
                    <div class="mb-3 border-bottom main-field">
                        @php
                        if (!empty($userFields)) {
                            foreach ($userFields as $userField) {
                                if ($userField["show_filter"] == 'N') {
                                    continue;
                                }

                                $val = null;
                                if (isset($filterMode[$userField['field_name']])) {
                                    $val = $filterMode[$userField['field_name']];
                                }

                                $userField['field_name'] = 'filter_mode['.$userField['field_name'].']';

                                @endphp
                                <div class="mb-2">
                                    @php
                                    if ($userField['user_type_id'] == 'string') {
                                        @endphp
                                        <label class="d-block">{{ $userField['list_filter_label'] }}</label>
                                        @include('August::widgets.string', ["userField" => $userField, 'value' => $val])
                                        @php
                                    } elseif ($userField['user_type_id'] == 'int') {
                                        @endphp
                                        <label class="d-block">{{ $userField['list_filter_label'] }}</label>
                                        @include('August::widgets.integer', ["userField" => $userField, 'value' => $val])
                                        @php
                                    } elseif ($userField['user_type_id'] == 'enum') {
                                        @endphp
                                        <label class="d-block">{{ $userField['list_filter_label'] }}</label>
                                        @include('August::widgets.enum', [
                                            "userField" => $userField, "listEnum" => $userField['list_enum'], 'value' => $val, 'view' => 'filter'
                                        ])
                                        @php
                                    } elseif ($userField['user_type_id'] == 'date') {
                                        @endphp
                                        <label class="d-block">{{ $userField['list_filter_label'] }}</label>
                                        @include('August::widgets.date', ["userField" => $userField, 'value' => $val, 'view' => 'filter'])
                                        @php
                                    } elseif ($userField['user_type_id'] == 'datetime') {
                                        @endphp
                                        <label class="d-block">{{ $userField['list_filter_label'] }}</label>
                                        @include('August::widgets.datetime', ["userField" => $userField, 'value' => $val, 'view' => 'filter'])
                                        @php
                                    } elseif ($userField['user_type_id'] == 'link_to_user') {
                                        @endphp
                                        <label class="d-block">{{ $userField['list_filter_label'] }}</label>
                                        @include('August::widgets.link_to_user', ["userField" => $userField, 'value' => $val])
                                        @php
                                    } elseif ($userField['user_type_id'] == 'link_to_user') {
                                        @endphp
                                        <label class="d-block">{{ $userField['list_filter_label'] }}</label>
                                        @include('August::widgets.link_to_user', ["userField" => $userField, 'value' => $val])
                                        @php
                                    } else {
                                        
                                    }
                                    @endphp
                                </div>
                                @php
                            }
                        }
                        @endphp
                        
                        <div class="mb-3 d-none">
                            <span class="btn-link">Thêm trường</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="submit" class="btn btn-primary">{{ trans('August::list.search') }}</button>
                        <input type="hidden" name="filter_mode[reset]" value="0">
                        <button type="button" class="btn btn-secondary reset-filter">{{ trans('August::list.reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('js')
<script src="/assets-august/js/widgets/august-filter.js"></script>
@endpush