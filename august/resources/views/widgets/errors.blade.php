@push('css')
    <link href="/assets-august/css/widgets/august-errors.css" rel="stylesheet" type="text/css" />
@endpush

@if ($errors->any())
<div class="error-message pt-2 pb-2 mb-3">
	<ul class="mb-0">
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif