<table class="table dt-responsive nowrap w-100 mb-0">
    <thead>
        <tr>
            <th><input class="form-check-input" type="checkbox"></th>
            @php
            foreach ($arElements['COLUMNS'] as $column) {
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
                    <td><input class="form-check-input" type="checkbox" onclick="chooseAblock('{{ $item[$showField]["value"] }}', '{{ $item["ID"]["value"] }}', '<?php echo $userField; ?>');"></td>
                    @foreach ($item as $cel)
                        
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
                    @endforeach
                </tr>
                @php
            }
        }
        @endphp
    </tbody>
</table>