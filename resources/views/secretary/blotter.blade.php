@extends('layouts.secretary-sidebar')
<style>
    .sidebar-issuance, .sidebar-blotters{
        color: rgb(180, 179, 179);
     }
 </style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary">Blotters</h4>

    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Incident Type</td>
                <td class="text-center">Complainant</td>
                <td class="text-center">Respondents</td>
                <td class="text-center">Settlement Date</td>
                <td class="text-center">Status</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    

{{-- add modal --}}
  <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="blotterForm" id="blotterForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Blotter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Complainant</label>
                        <div class="col-sm-9">
                            <select class="form-select select-user" aria-label="Default select example" name="user_id" id="select_user">
                                <option value=""></option>
                                @foreach ($residents as $resident )
                                    <option value="{{ $resident->id }}">{{ $resident->name }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Incident Type</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputPassword" name="incident_type">
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Respondent</label>
                        <div class="col-sm-9">
                            <select class="form-select select-user" aria-label="Default select example" name="respondents" id="select_respondent">
                                <option value=""></option>
                                @foreach ($residents as $resident )
                                    <option value="{{ $resident->name }}">{{ $resident->name }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Schedule Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="inputPassword" name="schedule_date">
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Date Reported</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="inputPassword" name="date_reported">
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Location <span class="text-muted" style="font-size: 11px">(optional)</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputPassword" name="location">
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Narrative</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" placeholder="Enter narrative here" name="narrative" id="narrative" style="height: 100px"></textarea>
                        </div>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" name="savedata" id="savedata" >Save</button>
                  <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
              </div>
        </form>
      </div>
    </div>
  </div>
    
<script>
    $(document).ready(function(){
        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        
        // select user 
        $('#select_user').select2({
            dropdownParent: $('#addModal'),
            theme: "bootstrap-5",
            placeholder: "Select complainant",
            allowClear: true,
            tags: true,
        });
        
        $('#select_respondent').select2({
            dropdownParent: $('#addModal'),
            theme: "bootstrap-5",
            placeholder: "Select respondent",
            allowClear: true,
            tags: true,
        });



        //load table
        let table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            select: true,
            ajax: "{{ route('barangay.blotter') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'incident_type', name: 'incident_type'},
                {data: 'complainant', name: 'complainant'},
                {data: 'respondents', name: 'complainant'},
                {data: 'schedule_date', name: 'schedule_date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="bi-plus-circle text-ce"></i> Add',
                    className: 'btn btn-success btn-sm',
                    action: function(e, dt, node, config){
                        // show modal
                        $('#id').val('');
                        $('#blotterForm').trigger("reset");
                        $('#addModal').modal('show');
                        $('#savedata').html('Save');
                    },
                }
            ]
        });

        //add function
        $('#savedata').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#blotterForm').serialize(),
            url: "{{ route('blotter.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#blotterForm').trigger("reset");
                    $('#addModal').modal('hide');
                    $('#select_user').val(null).trigger('change');
                    $('#select_respondent').val(null).trigger('change');
                    toastr.success('Blotter added successfully','Success');
                    table.draw();
                },
                error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteBlotter', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this blotter?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/blotter/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Blotter deleted successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });
        $('#submenu2').addClass('show').removeClass('hide');
    }); //end of script

</script>

@endsection
