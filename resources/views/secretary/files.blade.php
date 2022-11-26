@extends('layouts.secretary-sidebar')
<style>
   .sidebar-reports, .sidebar-files{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Files</h4>
    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">File Name</td>
                <td class="text-center">Title</td>
                <td class="text-center">Remarks</td>
                <td class="text-center">Date Uploaded</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="fileForm" id="fileForm" enctype="multipart/form-data">
            <input type="hidden" name="barangay_id" value="{{ $barangay_id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="zone" class="form-label">File:</label>
                        <input type="file" class="form-control" name="filename" id="file" placeholder="e.g. ">
                    </div>
                  <div class="mb-3">
                      <label for="zone" class="form-label">Title:</label>
                      <input type="text" class="form-control" name="title" id="title" placeholder="e.g. ">
                  </div>
                  <div class="mb-3">
                    <label for="zone" class="form-label">Remarks:</label>
                    <input type="text" class="form-control" name="remarks" id="remarks" placeholder="e.g. ">
                </div>

              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary" name="savedata" id="savedata" >Save</button>
                  <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
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
            responsive: true,
            select: true,
            ajax: "{{ route('report.file') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'file', name: 'file'},
                {data: 'title', name: 'title'},
                {data: 'remarks', name: 'remarks'},
                {data: 'created_at', name: 'created_at'},
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
                        $('#fileForm').trigger("reset");
                        $('#addModal').modal('show');
                        $('#savedata').html('Save');
                    },
                }
            ]
   
        });
        //add function
        $('#fileForm').submit(function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('report.store-file') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    $('#fileForm').trigger("reset");
                    table.draw();
                    toastr.success('File added successfully','Success');
                    $('#addModal').modal('hide');
                },
                error: function(data){
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteFile', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this file?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/report/file/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('File deleted successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });

        $('#submenu3').addClass('show').removeClass('hide');
    }); //end of script

</script>

@endsection
