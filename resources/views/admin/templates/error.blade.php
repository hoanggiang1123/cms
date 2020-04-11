@if ($errors->any())
<div id="form-error" class="alert fade show bgc-white brc-danger-l1 rounded" role="alert">
    <div class="position-tl h-102 border-l-4 brc-danger-tp1 m-n1px rounded-left"></div>

    <h5 class="alert-heading text-danger-m1 font-bolder"><i class="fas fa-exclamation-triangle mr-1 mb-1"></i> Error</h5>
    @foreach ($errors->all() as $error)
    <p class="my-1">{{ $error }}</p>
    @endforeach
</div>
<script>
    setTimeout(function() {
        document.getElementById('form-error').style.display = 'none';
    },3000)
</script>
@endif
