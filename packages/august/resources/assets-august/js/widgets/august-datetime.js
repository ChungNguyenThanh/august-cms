(function ($) {
    $(document).off('click', ".btn-add-input-datetime");
    $(document).on('click', ".btn-add-input-datetime", function (e) {
        let fieldName = $(this).attr("item-field-name");
        let mark = `
        <div class="d-flex gap-1 mb-1">
            <input type="datetime-local" id="`+fieldName+`" name="`+fieldName+`[]" value="" class="form-control">
            <span class="btn btn-danger btn-delete-input-datetime">Xoá</span>
        </div>
        `;
        $(this).before(mark);
    });

    $(document).off('click', ".btn-delete-input-datetime");
    $(document).on('click', ".btn-delete-input-datetime", function (e) {
        $(this).parent().remove();
    });
})(jQuery)
