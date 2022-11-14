@extends('layouts.backend')
@section('title','Customer')
@section('title','Customer Details')

@push('css_or_js')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row" id="printableArea">
        <div class="col-lg-8 mb-3 mb-lg-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-title"></h5>
                </div>
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th>#sl</th>
                                <th style="width: 50%" class="text-center">Order ID</th>
                                <th style="width: 50%">Total</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $key=>$order)
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td class="table-column-pl-0 text-center">
                                    <a href="<?= route('admin.orders.details', ['id' => $order['id']]) ?>"><?= $order['id'] ?></a>
                                </td>
                                <td> <?= \App\CPU\BackEndHelper::currency_symbol() . \App\CPU\BackEndHelper::usd_to_currency($order['order_amount']) ?></td>

                                <td>
                                    <!-- Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="tio-settings"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= route('admin.orders.details', ['id' => $order['id']]) ?>"><i class="tio-visible"></i> View</a>
                                            <a class="dropdown-item" target="_blank" href="<?= route('admin.orders.generate-invoice', [$order['id']]) ?>"><i class="tio-download"></i> Invoice</a>
                                        </div>
                                    </div>
                                    <!-- End Dropdown -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Footer -->
                    <div class="card-footer">
                        <!-- Pagination -->
                        {!! $orders->render('pagination') !!}
                        <!-- End Pagination -->
                    </div>
                    <!-- End Footer -->
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- Card -->
            <div class="card">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title">Customer</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->



                @if($customer)

                <div class="card-body">
                    <div class="media align-items-center" href="javascript:">
                        <div class="avatar avatar-circle mr-3">
                            <img class="round" onerror="this.src='<?= asset('assets/front-end/img/image-place-holder.png') ?>'" src="<?= asset($customer->image) ?>" alt="Image Description" width="40px">
                        </div>
                        <div class="media-body">
                            <span class="text-body text-hover-primary"><?= $customer['f_name'] . ' ' . $customer['l_name'] ?></span>
                        </div>
                        <div class="media-body text-right">
                            {{--<i class="tio-chevron-right text-body"></i>--}}
                        </div>
                    </div>

                    <hr>

                    <div class="media align-items-center" href="javascript:">
                        <div class="icon icon-soft-info icon-circle mr-3">
                            <i class="tio-shopping-basket-outlined"></i>
                        </div>
                        <div class="media-body">
                            <span class="text-body text-hover-primary"> <?= \App\Model\Order::where('customer_id', $customer['customer_id'])->count() ?> orders</span>
                        </div>
                        <div class="media-body text-right">
                            {{-- <i class="tio-chevron-right text-body"></i> --}}
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Contact info</h5>
                    </div>

                    <ul class="list-unstyled list-unstyled-py-2">
                        <li>
                            <i class="tio-online mr-2"></i>
                            <?= $customer['email'] ?>
                        </li>
                        <li>
                            <i class="tio-android-phone-vs mr-2"></i>
                            <?= $customer['phone'] ?>
                        </li>
                    </ul>

                    <hr>



                    <div class="d-flex justify-content-between align-items-center">
                        <h5><?= __('shipping_address') ?></h5>

                    </div>


                    <span class="d-block">
                        @if(isset($order))
                        <?= __('Name') ?> :
                        <strong><?= $order->shipping ? $order->shipping['contact_person_name'] : "empty" ?></strong><br>
                        <?= __('City') ?>:
                        <strong><?= $order->shipping ? $order->shipping['city'] : "Empty" ?></strong><br>
                        <?= __('zip_code') ?> :
                        <strong><?= $order->shipping ? $order->shipping['zip']  : "Empty" ?></strong><br>
                        <?= __('Phone') ?>:
                        <strong><?= $order->shipping ? $order->shipping['phone']  : "Empty" ?></strong><br>
                        <?= __('Address') ?>:
                        <strong><?= $order->shipping ? $order->shipping['address']  : "Empty" ?></strong>
                        <!-- <code>{{ var_dump($order->shipping) }}</code> -->
                    </span>
                    @endif

                </div>
                @endif

                <!-- End Body -->
            </div>
            <!-- End Card -->
        </div>
    </div>
    <!-- End Row -->
</div>
@endsection

@push('script_2')

<script>
    $(document).on('ready', function() {
        // INITIALIZATION OF DATATABLES
        // =======================================================
        var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

        $('#column1_search').on('keyup', function() {
            datatable
                .columns(1)
                .search(this.value)
                .draw();
        });


        $('#column3_search').on('change', function() {
            datatable
                .columns(2)
                .search(this.value)
                .draw();
        });


        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function() {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });
    });
</script>
@endpush