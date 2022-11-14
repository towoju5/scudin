<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.2/tinymce.min.js" integrity="sha512-Cwez4r594AFwCqWzXklkW90mGiJCKJBhcFb8GsWWtb0coKuR9uv1ozODWidI/8Lr9iKunYaXLPf6VJtL3rXzyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: [
            'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
            'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
            'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
    });
    // (".text-area").tinymce();
</script>

<link rel="stylesheet" href="{{ asset('toastr.css') }}">
<script src="{{ asset('toastr.min.js') }}"></script>
<!-- {!! Toastr::message() !!} -->
<?php /*
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
*/