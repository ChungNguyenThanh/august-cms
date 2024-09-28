(function ($) {
    $(document).off('click', ".btn-add-input-string");
    $(document).on('click', ".btn-add-input-string", function (e) {
        let fieldName = $(this).attr("item-field-name");
        let mark = `
        <div class="d-flex gap-1 mb-1">
            <input type="" id="`+fieldName+`" name="`+fieldName+`[]" value="" class="form-control">
            <span class="btn btn-danger btn-delete-input-string">Xoá</span>
        </div>
        `;
        $(this).before(mark);
    });

    $(document).off('click', ".btn-delete-input-string");
    $(document).on('click', ".btn-delete-input-string", function (e) {
        $(this).parent().remove();
    });
})(jQuery)
