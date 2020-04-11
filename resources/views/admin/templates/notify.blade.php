@if(session('hgcms_notify'))
<script>
	Swal.fire({
		position: 'top-end',
		icon: 'success',
		title: "{{ session('hgcms_notify') }}",
		showConfirmButton: false,
		timer: 1500
   })
</script>
@endif

