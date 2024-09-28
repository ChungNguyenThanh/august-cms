(function ($) {
    $(document).on("click", ".nav-link", function() {
        let id = $(this).attr('id');
        if (id == 'nav-access-tab') {
            $(".btn-access").addClass('d-inline');
            $(".btn-access").removeClass('d-none');
        } else {
            $(".btn-access").removeClass('d-inline');
            $(".btn-access").addClass('d-none');
        }
    });

    $(document).on("click", ".btn-access", function() {
        let ind = 0;
        let mark = '';
        let str_access_code = '';
        $('.item-right').each(function () {
            let user_id = $("input[name='entity_access["+ind+"][user_id]']").val();
            let access_code = $("input[name='entity_access["+ind+"][access_code]']").val();
            let provider_id = $("input[name='entity_access["+ind+"][provider_id]']").val();
            let name = $(this).find("label").text();
            let title = 'Nhân viên';
            let avt = 'http://localhost:8888/assets-august/images/users/default.png';

            str_access_code += ',' + access_code;
            
            if (provider_id == 'user') {
                mark += `
                <div class="d-flex align-items-center gap-1 p-1 item-choose mb-1" item-access-code="${access_code}" item-name="${name}" item-id="${user_id}" item-provider="user">
                    <img class="u-avatar img-fluid avatar-sm rounded-circle" src="${avt}">
                    <div class="u-name-title">
                        <div class="u-name">${name}</div>
                        <div class="u-title">${title}</div>
                    </div>
                    <span class="remove-usn">x</span>
                </div>
                `;
            } else {
                mark += `
                <div class="d-flex align-items-center gap-1 g-item p-1 item-choose mb-1" item-access-code="${access_code}" item-id="${user_id}" item-name="${name}" item-provider="group">
                    <img class="g-avatar img-fluid avatar-sm rounded-circle" src="${avt}">
                    <div class="g-name-title">
                        <div class="g-name">${name}</div>
                    </div>
                    <span class="remove-usn">x</span>
                </div>
                `;
            }
            ind++;
        });

        $(".list-choose-user").html(mark);
        $("input[name='list-choosed']").val(str_access_code);
    });

    $(document).on("click", "#access_modal .item-by", function() {
        let id = $(this).attr('item-id');
        $("#access_modal .item-by").removeClass("active");
        $(this).addClass("active");

        if (id == 'list-user') {
            $("#access_modal .list-role").removeClass("d-flex");
            $("#access_modal .list-role").removeClass("d-none");
            $("#access_modal .list-role").addClass("d-none");

            $("#access_modal .list-user").removeClass("d-none");
            $("#access_modal .list-user").removeClass("d-flex");
            $("#access_modal .list-user").addClass("d-flex");
        } else {
            $("#access_modal .list-role").removeClass("d-flex");
            $("#access_modal .list-role").removeClass("d-none");
            $("#access_modal .list-role").addClass("d-flex");

            $("#access_modal .list-user").removeClass("d-none");
            $("#access_modal .list-user").removeClass("d-flex");
            $("#access_modal .list-user").addClass("d-none");
        }
    });

    // choose user
    $(document).on("click", "#access_modal .choose-user", function() {
        let avt = $(this).find(".u-avatar").attr('src');
        let name = $(this).find(".u-name").text();
        let title = $(this).find(".u-title").text();
        let id = $(this).find(".u-id").val();
        let accessCode = "U" + id;

        let val = $("input[name='list-choosed']").val();
        let arUser = val.split(",");

        if (!arUser.includes(accessCode)) {
            let mark = `
            <div class="d-flex align-items-center gap-1 p-1 item-choose mb-1" item-access-code="${accessCode}" item-name="${name}" item-id="${id}" item-provider="user">
                <img class="u-avatar img-fluid avatar-sm rounded-circle" src="${avt}">
                <div class="u-name-title">
                    <div class="u-name">${name}</div>
                    <div class="u-title">${title}</div>
                </div>
                <span class="remove-usn">x</span>
            </div>
            `;

            $(".list-choose-user").append(mark);
            $("input[name='list-choosed']").val(val + ',' + accessCode);
        }
    });

    // choose roup
    $(document).on("click", "#access_modal .choose-group", function() {
        let avt = $(this).find(".g-avatar").attr('src');
        let name = $(this).find(".g-name").text();
        let id = $(this).find(".g-id").val();
        let accessCode = "G" + id;

        let val = $("input[name='list-choosed']").val();
        let arUser = val.split(",");

        if (!arUser.includes(accessCode)) {
            let mark = `
            <div class="d-flex align-items-center gap-1 g-item p-1 item-choose mb-1" item-access-code="${accessCode}" item-id="${id}" item-name="${name}" item-provider="group">
                <img class="g-avatar img-fluid avatar-sm rounded-circle" src="${avt}">
                <div class="g-name-title">
                    <div class="g-name">${name}</div>
                </div>
                <span class="remove-usn">x</span>
            </div>
            `;

            $(".list-choose-user").append(mark);
            $("input[name='list-choosed']").val(val + ',' + accessCode);
        }
    });


    $(document).on("click", "#access_modal .remove-usn", function() {
        let id = $(this).parent().attr("item-access-code");
        let val = $("input[name='list-choosed']").val();
        let arUser = val.split(",");
        let str = "";

        for (var i = 0; i < arUser.length; i++) {
            if (arUser[i].length == 0) {
                continue;
            }

            if (arUser[i] == id) {
                continue;
            }

            str += "," + arUser[i];
        }

        $("input[name='list-choosed']").val(str);

        $(this).parent().remove();
    });

    $(document).on("click", "#access_modal .btn-choose-access", function() {
        let mark = '';
        let ind = 0;
        $(".list-choose-user .item-choose").each(function () {
            let id = $(this).attr("item-id");
            let accessCode = $(this).attr("item-access-code");
            let providerId = $(this).attr("item-provider");

            let name = $(this).attr("item-name");
            mark += `
            <div class="mb-2 row item-right">
                <input type="hidden" name="entity_access[${ind}][user_id]" value="${id}">
                <input type="hidden" name="entity_access[${ind}][access_code]" value="${accessCode}">
                <input type="hidden" name="entity_access[${ind}][provider_id]" value="${providerId}">
                <label class="col-md-3 col-form-label text-end" for="example-color">${name}</label>
                <div class="col-md-9">
                    <div class="d-flex gap-1 mb-1">
                        <select class="form-control" name="entity_access[${ind}][access]">
                            ${selectTask}
                        </select>
                        <span class="btn btn-danger btn-delete-right">Xoá</span>
                    </div>
                </div>
            </div>
            `;

            ind++;
        });

        $("#access_modal .btn-close").trigger("click");
        $("#nav-access .list-access").html(mark);
    });

    $(document).on("click", ".btn-delete-right", function() {
        $(this).closest('.item-right').remove();
    });
})(jQuery)