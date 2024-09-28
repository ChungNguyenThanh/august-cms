@php
if (isset($view) && ($view == 'list')) {
    $fieldValue = '';
    if (isset($value)) {
        $fieldValue = $value;
    }

    if ($userField['multiple'] == 'Y') {
        if (is_array($fieldValue)) {
            foreach ($fieldValue as $val) {
                echo html_entity_decode($val)."<br>";
            }
        }
    } else {
        echo '<div>'.html_entity_decode($fieldValue).'</div>';
    }
} else {
    $fieldValue = '';
    if (isset($value)) {
        $fieldValue = $value;
    }

    if ($userField['multiple'] == 'Y') {
        for ($i=0; $i < 20; $i++) {
            if (isset($fieldValue[$i])) {
                $style = '';
            } else {
                $style = 'd-none';
            }
            @endphp
            <div class="d-flex gap-1 mb-1 {{ $style }}" id="html_{{ $userField['field_name'].'_'.$i }}">
                <div>
                    <div id="{{ $userField['field_name'].'_'.$i }}" style="height: 300px;" class="ql-container ql-snow"></div>
                    <input type="hidden" name="{{ $userField['field_name'] }}[{{ $i }}]">
                </div>
                <span class="btn btn-danger btn-delete-input-html align-self-start">Xoá</span>
            </div>
            @php
        }

        $countVal = 0;
        if (is_array($fieldValue) && !empty($fieldValue)) {
            $countVal = count($fieldValue);
        }
        @endphp
        <span class="btn btn-success btn-add-input-html" item-field-name="{{ $userField['field_name'] }}" item-index="{{ $countVal }}">Thêm</span>
        @php
    } else {
        @endphp
        <div id="{{ $userField['field_name'] }}" style="height: 300px;" class="ql-container ql-snow"></div>
        <input type="hidden" name="{{ $userField['field_name'] }}">
        @php
    }
}
@endphp

@push('js')
    @php
    if (isset($view) && ($view == 'list')) {

    } else {
        @endphp
        <script type="text/javascript">
            @php
            if ($userField['multiple'] == 'Y') {
                for ($i=0; $i < 20; $i++) {
                    @endphp
                    var quill_{{ $i }} = new Quill(
                        "#{{ $userField['field_name'].'_'.$i }}",
                        {
                            theme:"snow",
                            modules:{
                                toolbar:[
                                    [{font:[]}, {size:[]}],
                                    ["bold","italic","underline","strike"],
                                    [{color:[]},{background:[]}],
                                    [{script:"super"},{script:"sub"}],
                                    [
                                        {header:[!1,1,2,3,4,5,6]},
                                        "blockquote","code-block"
                                        ],
                                    [
                                        {list:"ordered"},
                                        {list:"bullet"},
                                        {indent:"-1"},
                                        {indent:"+1"}
                                        ],
                                    [
                                        "direction",
                                        {align:[]}
                                        ],
                                    ["link","image","video"],
                                    ["clean"]
                                ]
                            }
                        }
                    );

                    quill_{{ $i }}.on('editor-change', (eventName, ...args) => {
                        let html = $("#{{ $userField['field_name'].'_'.$i }} .ql-editor").html();
                        $("input[name='{{ $userField['field_name'] }}[{{ $i }}]']").val(html);
                    });

                    @php
                    if (!empty($fieldValue[$i])) {
                        @endphp
                        var delta = quill_{{ $i }}.clipboard.convert('<?php echo html_entity_decode($fieldValue[$i]); ?>');
                        quill_{{ $i }}.setContents(delta, 'silent');
                        @php
                    }
                }
            } else {
                @endphp
                var quill = new Quill(
                    "#{{ $userField['field_name'] }}",
                    {
                        theme:"snow",
                        modules:{
                            toolbar:[
                                [{font:[]}, {size:[]}],
                                ["bold","italic","underline","strike"],
                                [{color:[]},{background:[]}],
                                [{script:"super"},{script:"sub"}],
                                [
                                    {header:[!1,1,2,3,4,5,6]},
                                    "blockquote","code-block"
                                    ],
                                [
                                    {list:"ordered"},
                                    {list:"bullet"},
                                    {indent:"-1"},
                                    {indent:"+1"}
                                    ],
                                [
                                    "direction",
                                    {align:[]}
                                    ],
                                ["link","image","video"],
                                ["clean"]
                            ]
                        }
                    }
                );
                quill.on('editor-change', (eventName, ...args) => {
                    let html = $("#{{ $userField['field_name'] }} .ql-editor").html();
                    $("input[name='{{ $userField['field_name'] }}']").val(html);
                });

                var delta = quill.clipboard.convert('<?php echo html_entity_decode($fieldValue); ?>');
                quill.setContents(delta, 'silent');
                @php
            }
            @endphp

            (function ($) {
                $(document).off('click', ".btn-add-input-html");
                $(document).on('click', ".btn-add-input-html", function (e) {
                    let fieldName = $(this).attr("item-field-name");
                    let itemIndex = $(this).attr("item-index");
                    $("#html_" + fieldName + "_" + itemIndex).removeClass('d-none');
                    $(this).attr("item-index", parseInt(itemIndex) + 1);
                });

                $(document).off('click', ".btn-delete-input-html");
                $(document).on('click', ".btn-delete-input-html", function (e) {
                    $(this).parent().remove();
                });
            })(jQuery)
        </script>
        @php
        }
    @endphp
@endpush