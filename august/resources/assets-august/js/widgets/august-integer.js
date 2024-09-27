(function ($) {
    $(document).off('click', ".btn-add-input-number");
    $(document).on('click', ".btn-add-input-number", function (e) {
        let fieldName = $(this).attr("item-field-name");
        let mark = `
        <div class="d-flex gap-1 mb-1">
            <input type="number" id="`+fieldName+`" name="`+fieldName+`[]" value="" class="form-control">
            <span class="btn btn-danger btn-delete-input-number">Xoá</span>
        </div>
        `;
        $(this).before(mark);
    });

    $(document).off('click', ".btn-delete-input-number");
    $(document).on('click', ".btn-delete-input-number", function (e) {
        $(this).parent().remove();
    });
})(jQuery)
