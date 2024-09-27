if (typeof chooseBy !== 'function') {
	function chooseBy(id, field_name, dom) {
		$("#user-modal_"+field_name+" .u-items").css('display', 'none');


		if (id == "group") {
			$("#user-modal_"+field_name+" #" + id).css('display', 'block');
		} else {
			$("#user-modal_"+field_name+" #" + id).css('display', 'flex');
		}

		$("#user-modal_"+field_name+" .item-by").removeClass('active');
		$(dom).addClass('active');

		if (id == "search") {
			$(".form-search-user").removeClass('d-none');
		} else {
			$(".form-search-user").addClass('d-none');
		}
	}
}

function getUserGroup_TEST_USER(id) {
	$.ajax({
		url: '/admin/index.php?r=extendblock/ajax/index',
		type: "post",
		data: {
			ajaxFile: '/Applications/MAMP/htdocs/vivicorp/vidmf/vendor/dmf/extendblock/components/ext/elements.add/ajax.php',
			id: id,
			action: 'getUserGroup',
			callback: 'chooseUser'
		},
		success: function(res) {
			$("#user-modal_TEST_USER #group #gr_" + id).html(res);
			$("#user-modal_TEST_USER #group #gr_" + id).css('display', 'flex');
		},
		error: function(request, status, error) {
			console.log(request.responseText);
		}
	});
}

if (typeof chooseUser !== 'function') {
	function searchUser(field_name, dom) {
		let name = $(dom).val();
		let route = $("input[name='route_"+field_name+"']").val();

		$.ajax({
			url: route,
			type: "post",
			data: {
				"_token": $("input[name='_token']").val(),
				name: name,
			},
			success: function(res) {
				$("#search").html(res);
			},
			error: function(request, status, error) {
				console.log(request.responseText);
			}
		});
	}
}

if (typeof chooseUser !== 'function') {
	function chooseUser(name, id, field_name) {
		let mark = `<span class="us-name">`+name+` <span class="remove-usn" onclick="removeUsName('`+id+`', '`+field_name+`', this)">x</span></span>`;

		let old_id = $("input[name='"+field_name+"").val();

		$("#user_old").remove();

		// Trường hợp này dành cho multi user
		// $("input[name='"+field_name+"']").val(old_id + "," + id);

		$("input[name='"+field_name+"']").val(id);

		$("#link_to_user_"+field_name+" span.chooseuser").html(mark);
		$("#link_to_user_"+field_name+" span.chooseuser").css('display', 'inline');

		$("#user-modal_"+field_name+" .btn-close").trigger("click");
	}
}

if (typeof removeUsName !== 'function') {
	function removeUsName(id, field_name, dom) {
		$(dom).parent().remove();
		let old_id = $("input[name='"+field_name+"").val();

		old_id = old_id.replace("," + id, '');

		$("input[name='"+field_name+"']").val(old_id);
	}
}