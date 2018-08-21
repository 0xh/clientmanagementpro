<script>
    window.Evolutly = {!! json_encode(array_merge(
        Evolutly::scriptVariables(), [
            'guard' => $guard
        ]
    ))!!}
</script>