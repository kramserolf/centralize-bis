@extends('layouts.admin-sidebar')
<style>
      .admin-blotter{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Blotters </h4>

    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Barangay</td>
                <td class="text-center">Incident Type</td>
                <td class="text-center">Location</td>
                <td class="text-center">Status</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
  {{-- view modal --}}
  <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <label for="staticEmail" class="col-sm-3 col-form-label">Barangay:</label>
                        <div class="col-sm-9">
                            <p class="fw-bold fs-5 mt-1" id="view_barangay"></p>
                        </div>
                      </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Complainant:</label>
                        <div class="col-sm-9">
                            <p class="fw-bold fs-5 mt-1" id="view_complainant"></p>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Incident Type:</label>
                        <div class="col-sm-9">
                            <p class="fw-bold fs-5 mt-1" id="view_incident"></p>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Respondent:</label>
                        <div class="col-sm-9">
                            <p class="fw-bold fs-5 mt-1" id="view_respondent"></p>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Schedule Date:</label>
                        <div class="col-sm-9">
                            <p class="fw-bold fs-5 mt-1" id="view_schedule_date"></p>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Date Reported:</label>
                        <div class="col-sm-9 fs-5 mt-1">
                            <p class="fw-bold fs-5 mt-1" id="view_date_reported"></p>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Location:</label>
                        <div class="col-sm-9">
                            <p class="fw-bold fs-5 mt-1" id="view_location"></p>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Narrative:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" placeholder="Enter narrative here" name="view_narrative" id="view_narrative" style="height: 100px"></textarea>
                        </div>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
              </div>
        </form>
      </div>
    </div>
  </div>

<script>
    
    $(document).ready(function(){
        // $('#barangay').trigger('click');

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //load table
        let table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            responsive: true,
            ajax: "{{ route('admin.blotter') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'barangay', name: 'barangay'},
                {data: 'incident_type', name: 'incident_type'},
                {data: 'location', name: 'location'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
        });

        //show modal
            // SHOW ADD MODAL
        $('#addBarangay').click(function () {
            $('#id').val('');
            $('#barangayForm').trigger("reset");
            $('#addModal').modal('show');
            $('#savedata').html('Save');
        });

        //add function
        $('#savedata').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#barangayForm').serialize(),
            url: "{{ route('barangay.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#barangayForm').trigger("reset");
                    $('#addModal').modal('hide');
                    table.draw();
                    toastr.success('Barangay added successfully','Success');
                },
                error: function (data) {
                    console.log('Error:', data);

                }
            });
        });

                
        // EDIT 
        $('body').on('click', '.viewBlotter', function () {
            var id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{ url('admin/blotters/view') }}",
                data:{
                id:id
                },
                success: function (data) {
                    $('#viewModal').modal('show');
                    $('#id').val(id);
                    $('#view_barangay').html(data.barangayName);
                    $('#view_complainant').html(data.complainant);
                    $('#view_incident').html(data.incident_type);
                    $('#view_respondent').html(data.respondents);
                    $('#view_schedule_date').html(data.schedule_date);
                    $('#view_date_reported').html(data.date_reported);
                    $('#view_location').html(data.location);
                    $('#view_narrative').val(data.narrative);
                },
                error: function (data) {
                toastr.error(data['responseJSON']['message'],'Error has occured');
                }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteBarangay', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this barangay?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/barangay/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Barangay deleted successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });

    }); //end of script


</script>

@endsection
