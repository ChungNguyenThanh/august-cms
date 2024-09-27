(function ($) {
    $(document).off('click', ".btn-add-input-date");
    $(document).on('click', ".btn-add-input-date", function (e) {
        let fieldName = $(this).attr("item-field-name");
        let mark = `
        <div class="d-flex gap-1 mb-1">
            <input type="date" id="`+fieldName+`" name="`+fieldName+`[]" value="" class="form-control">
            <span class="btn btn-danger btn-delete-input-date">Xoá</span>
        </div>
        `;
        $(this).before(mark);
    });

    $(document).off('click', ".btn-delete-input-date");
    $(document).on('click', ".btn-delete-input-date", function (e) {
        $(this).parent().remove();
    });
})(jQuery)
