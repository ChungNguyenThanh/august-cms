(function ($) {
    // August Serach Toggle
    var augustDropDows = $('.august-search .dropdown');

    // hide on other click
    $(document).on('click', function (e) {
        if (e.target.id == "august-top-search" || e.target.closest('#august-search-dropdown')) {
            $('#august-search-dropdown').addClass('d-block');
        } else {
            $('#august-search-dropdown').removeClass('d-block');
        }
        return true;
    });

    // August Serach Toggle
    $('#august-top-search').on('focus', function (e) {
        e.preventDefault();
        augustDropDows.children('.dropdown-menu.show').removeClass('show');
        $('#august-search-dropdown').addClass('d-block');
        return false;
    });

    // hide August search on opening other dropdown
    augustDropDows.on('show.bs.dropdown', function () {
        $('#august-search-dropdown').removeClass('d-block');
    });

    // reset filter
    $(document).on('click', '.reset-filter', function (e) {
        $('.august-search .main-field input').each(function () {
            $(this).val('');
        });

        
        $('.august-search input[name="filter_mode[reset]"]').val(1);

        $('#august_search').submit();
    });  
})(jQuery)
