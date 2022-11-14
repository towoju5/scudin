<ul class="products-grid">
  @foreach($products as $product)
  @if(!empty($product['product_id']))
  @php($product=$product->product)
  @endif
  @if(!empty($product))
  @include('web-views.partials._single-product', ['p'=>$product])
  @endif
  @endforeach
</ul>
<?php 
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
  $__id = $_REQUEST['id'];
} else if (isset($product['id']) && !empty($product['id'])) {
  $__id = $product['id'];
} else {
  $__id = '';
}
?>

<script>
  function filter(value) {
    $.ajax({
      url: "{{ url('products') }}",
      type: 'get',
      data: {
        id: "{{ $__id }}",
        name: "{{$products['name']}}",
        data_from: "{{ $_GET['data_from'] ?? $products['data_from'] }}",
        min_price: "{{ $products['min_price'] }}",
        max_price: "{{ $products['max_price'] }}",
        sort_by: value
      },
      dataType: 'json',
      beforeSend: function() {
        $('#loading').show();
      },
      success: function(response) {
        $('#loading').hide();
        $('#ajax-products').empty().append(response.view);
      },
      complete: function() {
        $('#loading').hide();
      },
    });
  }
</script>