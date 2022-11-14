<link rel="stylesheet" href="{{ asset('toastr.css') }}">
<script src="{{ asset('toastr.min.js') }}"></script>
{!! Toastr::message() !!}

@if ($errors->any())
@foreach($errors->all() as $error)
<script>
    toastr.error('{{$error}}', {
        CloseButton: true,
        ProgressBar: true
    });
</script>
@endforeach
@endif