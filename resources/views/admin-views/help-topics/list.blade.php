@extends('layouts.backend')
@section('title','FAQ')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-2">
        <h1 class="h3 mb-0 text-black-50"></h1>
        <button class="btn btn-primary btn-icon-split for-addFaq" data-toggle="modal" data-target="#addModal">
            <i class="tio-add-circle"></i>
            <span class="text">{{__('Add')}} {{__('faq')}} </span></button>
    </div>


    <!-- Accordion with margin start -->
    <section id="accordion-with-margin">
        <div class="row">
            <div class="col-sm-12">
                <div class="card collapse-icon">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">{{__('help_topic')}} {{__('List')}} </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <p class="card-text">
                            To create a collapse with margin use <code>.collapse-margin</code> class as a wrapper for your collapse
                            header.
                        </p> -->
                        <div class="collapse-margin" id="accordionExample">
                            @foreach($helps as $k => $help)
                            <div class="card">
                                <!-- <a class="dropdown-item delete" style="cursor: pointer;" id="{{$help['id']}}"> {{ __('Delete')}}</a> -->
                                <div class="card-header" id="headingOne{{$k}}" data-toggle="collapse" role="button" data-target="#collapseOne{{$k}}" aria-expanded="false" aria-controls="collapseOne">
                                    <span class="lead collapse-title"> {{$help['question']}} </span>
                                    <div class="d-flex justify-content-right">
                                        <a class="edit btn btn-primary" style="cursor: pointer;" data-toggle="modal" data-target="#editModal" data-id="{{ $help->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a data-id="{{ $help->id }}" class="btn btn-danger delete float-right">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>

                                <div id="collapseOne{{$k}}" class="collapse" aria-labelledby="headingOne{{$k}}" data-parent="#accordionExample">
                                    <div class="card-body">
                                        {{$help['answer']}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Accordion with margin end -->


    {{-- add modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Help Topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.helpTopic.add-new') }}" method="post" id="addForm">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" class="form-control" name="question" placeholder="Type Question">
                        </div>


                        <div class="form-group">
                            <label>Answer</label>
                            <textarea class="form-control" name="answer" cols="5" rows="5" placeholder="Type Answer"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="control-label">Status</div>
                                    <label class="custom-switch">
                                        <input type="checkbox" name="status" id="e_status" value="1" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
                                </div>
                            </div>
<!-- 
                            <div class="col-md-6">
                                <label for="ranking">Ranking</label>
                                <input type="number" name="ranking" class="form-control" autofoucs>
                            </div> -->
                        </div>

                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- edit modal --}}

<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Modal Help Topic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="editForm">
                @csrf
                {{-- @method('put') --}}
                <div class="modal-body">

                    <div class="form-group">
                        <label>Question</label>
                        <input type="text" class="form-control" name="question" placeholder="Type Question" id="e_question" class="e_name">
                    </div>


                    <div class="form-group">
                        <label>Answer</label>
                        <textarea class="form-control" name="answer" cols="5" rows="5" placeholder="Type Answer" id="e_answer"></textarea>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-4">

                        </div>

                        <div class="col-md-4">
                            <label for="ranking">Ranking</label>
                            <input type="number" name="ranking" class="form-control" id="e_ranking" required autofoucs>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div> -->

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">update</button>
            </form>
        </div>
    </div>
</div>
</div>



</div>
@endsection

@push('js')
<!-- Page level plugins -->
<script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('assets/back-end')}}/js/demo/datatables-demo.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    $(document).on('click', ".status_id", function() {
        let id = $(this).attr('data-id');

        $.ajax({
            url: "status/" + id,
            type: 'get',
            dataType: 'json',
            success: function(res) {
                toastr.success(res.success);
                window.location.reload();
            }

        });

    });
    $(document).on('click', '.edit', function() {
        let id = $(this).attr("data-id");
        console.log(id);
        $.ajax({
            url: "edit/" + id,
            type: "get",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                tinymce.get('e_answer').setContent(data.answer)
                $("#e_question").val(data.question);
                $("#e_answer").val(data.answer);
                $("#e_ranking").val(data.ranking);
                $("#editForm").attr("action", "update/" + data.id);
            }
        });
    });
    
    $(document).on('click', '.delete', function() {
        var id = $(this).attr("data-id");
        alert(id)
        Swal.fire({
            title: 'Are you sure delete this FAQ?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('admin.helpTopic.delete')}}",
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function() {
                        toastr.success('FAQ deleted successfully');
                        location.reload();
                    }
                });
            }
        })
    });
</script>
@endpush