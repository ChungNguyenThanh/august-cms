<div class="card mb-1">
    <div class="card-body overflow-auto" id="list-element">
        <table class="table dt-responsive nowrap w-100 mb-0">
            <thead>
                <tr>
                    <th><input class="form-check-input" type="checkbox"></th>
                    @php
                    foreach ($arElements['COLUMNS'] as $key => $column) {
                        if ($key != 'ID' && $key != $showField) {
                            continue;
                        }
                        @endphp
                        <th>{{ $column }}</th>
                        @php
                    }
                    @endphp
                </tr>
            </thead>
            <tbody>
                @php
                if (isset($arElements['ITEMS']) && !empty($arElements['ITEMS'])) {
                    foreach ($arElements['ITEMS'] as $item) {
                        @endphp
                        <tr>
                            <td><input class="form-check-input choose-element" item-id="{{ $item['ID']['value'] }}" item-show-field-val="{{ $item[$showField]['value'] }}" id="checkbox_{{ $userField }}_{{ $item['ID']['value'] }}" type="checkbox" onclick="addElementToQuee(this, '{{ $userField }}')"></td>
                            @php
                            foreach ($item as $key => $cel) {
                                if ($key != 'ID' && $key != $showField) {
                                    continue;
                                }
                                @endphp
                                <td>
                                    @php
                                    if ($cel['user_type_id'] == 'string') {
                                        @endphp
                                        @include('August::widgets.string', [
                                            "value" => $cel['value'],
                                            "view" => 'list',
                                            "userField" => $cel['user_field']
                                        ])
                                        @php
                                    } elseif ($cel['user_type_id'] == 'int') {
                                        @endphp
                                        @include('August::widgets.integer', [
                                            "value" => $cel['value'],
                                            "view" => 'list',
                                            "userField" => $cel['user_field']
                                        ])
                                        @php
                                    } elseif ($cel['user_type_id'] == 'date') {
                                        @endphp
                                        @include('August::widgets.date', [
                                            "value" => $cel['value'],
                                            "view" => 'list',
                                            "userField" => $cel['user_field']
                                        ])
                                        @php
                                    } elseif ($cel['user_type_id'] == 'datetime') {
                                        @endphp
                                        @include('August::widgets.datetime', [
                                            "value" => $cel['value'],
                                            "view" => 'list',
                                            "userField" => $cel['user_field']
                                        ])
                                        @php
                                    } elseif ($cel['user_type_id'] == 'enum') {
                                        @endphp
                                        @include('August::widgets.enum', [
                                            "value" => $cel['value'],
                                            "view" => 'list',
                                            "userField" => $cel['user_field'],
                                            "listEnum" => $cel['list_enum']
                                        ])
                                        @php
                                    } elseif ($cel['user_type_id'] == 'link_to_user') {
                                        @endphp
                                        @include('August::widgets.link_to_user', [
                                            "value" => $cel['value'],
                                            "view" => 'list',
                                            "userField" => $cel['user_field']
                                        ])
                                        @php
                                    }
                                    @endphp
                                </td>
                                @php
                            }
                            @endphp
                        </tr>
                        @php
                    }
                }
                @endphp
            </tbody>
        </table>
    </div>
</div>
<div class="card mb-0">
    <div class="card-body pt-0 pb-0">
        <table class="table dt-responsive nowrap w-100 mb-0" id="table-element">
            <tr class="border-0">
                <td class="align-middle border-0">Toàn bộ: {{ $arElements["TOTAL_ITEMS"] }}</td>
                <td class="align-middle border-0">
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="basic-datatable_paginate">
                            <ul class="pagination pagination-rounded mb-0">
                                @php 
                                $previous = '';
                                if ($arElements['PAGE'] == 1) {
                                    $previous = 'disabled';
                                }
                                @endphp
                                <li class="paginate_button page-item previous {{ $previous }}" id="basic-datatable_previous">
                                    <span class="pointer page-link popup-table" onclick="showListElement('{{ $ablockId }}', '{{ $userField }}', '{{ $showField }}', '{{ $multiple }}', '{{ $arElements["PAGE"] - 1 }}');">
                                        <i class="mdi mdi-chevron-left"></i>
                                    </span>
                                </li>
                                @php
                                for ($i = 1; $i <= $arElements['TOTAL_PAGES']; $i++) {
                                    $active = '';
                                    if ($arElements['PAGE'] == $i) {
                                        $active = 'active';
                                    }
                                    if ($i <= 5) {
                                    @endphp
                                    <li class="paginate_button page-item {{ $active }}">
                                        <span class="pointer page-link popup-table" onclick="showListElement('{{ $ablockId }}', '{{ $userField }}', '{{ $showField }}', '{{ $multiple }}', '{{ $i }}');">
                                            {{ $i }}
                                        </span>
                                    </li>
                                    @php 
                                    }
                                }
                                
                                $next = '';
                                if ($arElements['PAGE'] == $arElements['TOTAL_PAGES']) {
                                    $next = 'disabled';
                                }
                                @endphp
                                <li class="paginate_button page-item next {{ $next }}" id="basic-datatable_next">
                                    <span class="pointer page-link popup-table" onclick="showListElement('{{ $ablockId }}', '{{ $userField }}', '{{ $showField }}', '{{ $multiple }}', '{{ $arElements["PAGE"] + 1 }}');">
                                        <i class="mdi mdi-chevron-right"></i>
                                    </span>
                                </li>
                            </ul>

                        </div>
                    </div>
                </td>
                <td class="align-middle border-0">
                    
                </td>
            </tr>
        </table><!-- table pagination -->
    </div> <!-- end card body-->
</div> <!-- end card -->