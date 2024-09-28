if (typeof removeImage !== 'function') {
	function removeImage(id, field_name, ablock_id, multi, dom) {
        $.ajax({
			url: $("input[name='route']").val(),
			type: "post",
			data: {
				"_token": $("input[name='_token']").val(),
				id: id,
                field_name:field_name,
                ablock_id:ablock_id,
                multiple:multi
			},
			success: function(res) {
				$(dom).parent().remove();
			},
			error: function(request, status, error) {
				console.log(request.responseText);
			}
		});
	}
}
