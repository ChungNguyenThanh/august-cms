if (typeof chooseAblock !== 'function') {
	function chooseAblock(name, id, field_name) {
		let mark = `<span class="us-name">`+name+` <span class="remove-usn" onclick="removeAblock('`+id+`', this)">x</span></span>`;

		$("#ablock_old").remove();
		$("#show_field").remove();

		$('input[name="settings['+field_name+']"]').val(id);
		$("#link_to_user_"+field_name+" span.chooseuser").html(mark);
		$("#link_to_user_"+field_name+" span.chooseuser").css('display', 'inline');

		$("#user-modal_"+field_name+" .btn-close").trigger("click");

		$.ajax({
			url: $("input[name='route']").val(),
			type: "post",
			data: {
				"_token": $("input[name='_token']").val(),
				id: id
			},
			success: function(res) {
				$("#link_to_ablock").after(res);
			},
			error: function(request, status, error) {
				console.log(request.responseText);
			}
		});

		
	}
}

$('select[name="user_type_id"]').on('change', function() {
    if ($(this).val() === 'link_to_element') {
        $('#link_to_ablock').removeClass('d-none');
    } else {
		$('input[name="settings[link_to_ablock]"]').val('');
        $('#link_to_ablock').addClass('d-none');
    }
});

if (typeof removeAblock !== 'function') {
	function removeAblock(id, dom) {
		$(dom).parent().remove();
		$("#show_field").remove();
		
		// let old_id = $("input[name='"+field_name+"").val();

		// old_id = old_id.replace("," + id, '');

		// $("input[name='"+field_name+"']").val(old_id);
	}
}