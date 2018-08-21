<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ])!!}
    window.Spark = {!! json_encode(array_merge(
        Spark::scriptVariables(), []
    ))!!}
</script>