@extends('layouts.backend')

@section('title','Menu List')

@push('css_or_js')

@endpush

@section('content')
<section class="app-user-list">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">Menu List</h1>
            </div>
        </div>
    </div>
    <!-- list section start -->
    <div class="card">
        <div class="card-datatable table-responsive p-1">
            <table class="table" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th>{{ __('Menu Title') }}</th>
                        <th>{{ __('Menu Type') }}</th>
                        <th>{{ __('Menu Column') }}</th>
                        <th>{{ __('Menu Link') }}</th>
                        <th>{{ __('actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr>
                        <td>{{ $menu->menu_title }}</td>
                        <td>{{ $menu->menu_type }}</td>
                        <td>{{ $menu->menu_column }}</td>
                        <td>
                            <a href="{{ $menu->menu_link }}" target="_blank">{{ $menu->menu_link }}</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.menu.edit', $menu->id) }}">
                              <button class="btn btn-primary btn-sm">Edit</button>
                            </a> 
                            <a href="{{ route('admin.menu.delete', $menu->id) }}">
                              <button class="btn btn-info btn-sm">Delete</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right">
                {!! $menus->render('pagination') !!}
            </div>
        </div>
    </div>
    <!-- list section end -->
</section>
@endsection