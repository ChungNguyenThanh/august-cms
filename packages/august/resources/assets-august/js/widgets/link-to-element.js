if (typeof chooseAblock !== 'function') {
	function chooseAblock(name, id, field_name) {
		let mark = `<span class="us-name">`+name+` <span class="remove-usn" onclick="removeAblock('`+id+`', '`+field_name+`', this)">x</span></span>`;

		$("#element_old").remove();

		$('input[name='+field_name+']').val(id);
		$("#link_to_user_"+field_name+" span.chooseuser").html(mark);
		$("#link_to_user_"+field_name+" span.chooseuser").css('display', 'inline');

		$("#user-modal_"+field_name+" .btn-close").trigger("click");
	}
}

if(typeof showListElement !== 'function') {
	function showListElement(id, field_name, show_field, multiple, page = 1) {
		let route = $("input[name='route_"+field_name+"']").val();
		let search = $("#search_" + field_name).val();
		$.ajax({
			url: route,
			type: "post",
			data: {
				"_token": $("input[name='_token']").val(),
				id: id,
				userField: field_name,
				showField: show_field,
				multiple: multiple,
				search: search,
				page: page
			},
			success: function(res) {
				$("#user-modal_" + field_name + " .modal-body .table-element").html(res);
			},
			error: function(request, status, error) {
				console.log(request.responseText);
			}
		});
	}
}

if (typeof removeAblock !== 'function') {
	function removeAblock(id, field_name, dom) {
		$(dom).parent().remove();
		let old_id = $("input[name='"+field_name+"").val();

		old_id = old_id.replace("," + id, '');

		$("input[name='"+field_name+"']").val(old_id);
	}
}

if (typeof selectElements !== 'function') {
	function selectElements(field_name, multiple) {
		$("#link_to_user_"+field_name+" span.chooseuser").css('display', 'inline-flex');
		let mark = '';
		let strId = '';
		$("#user-modal_" + field_name + ' .list-select-element .select-element input').each(function (e) {
			let id = $(this).attr("item-id");
			let title = $(this).val();

			if (multiple == 'N') {
				mark = `<span class="us-name">`+title+` <span class="remove-usn" onclick="removeAblock('`+id+`', '`+field_name+`', this)">x</span></span>`;
				strId = `<input type="hidden" name="${field_name}" value="${id}">`;
			} else {
				mark += `<span class="us-name">`+title+` <span class="remove-usn" onclick="removeAblock('`+id+`', '`+field_name+`', this)">x</span></span>`;
				strId += `<input type="hidden" name="${field_name}[]" value="${id}">`;
			}
		});

		$("#link_to_user_"+field_name+" span.chooseuser").html(mark);
		$("#link_to_user_"+field_name).append(strId);
		$("#user-modal_"+field_name+" .btn-close").trigger("click");
	}
}

if (typeof addElementToQuee !== 'function') {
	function addElementToQuee(dom, field_name) {
		let id = $(dom).attr("item-id");
		let title = $(dom).attr("item-show-field-val");

		if ($(dom).is(":checked")) {
			let mark = `
			<div class="select-element" id="selected_element_id_${id}">
				${title}
				<span class="remove-el" onclick="removeEl('${id}', '${field_name}')">x</span>
				<input type="hidden" value="${title}" item-id="${id}">
			</div>`;
			$("#user-modal_" + field_name + ' .list-select-element').append(mark);
		} else {
			$(`#user-modal_${field_name} .list-select-element #selected_element_id_${id}`).remove();
		}
	}
}


if (typeof removeEl !== 'function') {
	function removeEl(id, field_name) {
		$(`#checkbox_${field_name}_${id}`).prop('checked', false);
		$(`#user-modal_${field_name} .list-select-element #selected_element_id_${id}`).remove();
	}
}

if (typeof removeSelectElement !== 'function') {
	function removeSelectElement(id, field_name, dom) {
		$(dom).parent().parent().remove();
	}
}

if (typeof searchElement !== 'function') {
	function searchElement(id, field_name, show_field, multiple) {
		let search = $("#search_" + field_name).val();
		let route = $("input[name='route_"+field_name+"']").val();
		
		$.ajax({
			url: route,
			type: "post",
			data: {
				"_token": $("input[name='_token']").val(),
				id: id,
				userField: field_name,
				showField: show_field,
				multiple: multiple,
				search: search,
				page: 1
			},
			success: function(res) {
				$("#user-modal_" + field_name + " .modal-body .table-element").html(res);
			},
			error: function(request, status, error) {
				console.log(request.responseText);
			}
		});
	}
}