@extends('layouts.admin-sidebar')
<style>
      .admin-barangay{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Barangay List</h4>

    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Barangay</td>
                <td class="text-center">Brgy. Captain</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

{{-- add modal --}}
  <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="barangayForm" id="barangayForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Barangay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                  <div class="mb-3">
                      <label for="barangayName" class="form-label">Barangay</label>
                      <input type="text" class="form-control text-capitalize" name="barangayName" id="barangayName" placeholder="dalin">
                  </div>
                  <div class="mb-3">
                      <label for="barangayCaptain" class="form-label">Barangay Captain</label>
                      <input type="text" class="form-control text-capitalize" name="barangayCaptain" id="barangayCaptain" placeholder="Juan Dela Cruz">
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
            ajax: "{{ route('barangay') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'barangayName', name: 'barangayName'},
                {data: 'barangayCaptain', name: 'barangayCaptain'},
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
                        $('#barangayForm').trigger("reset");
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
            data: $('#barangayForm').serialize(),
            url: "{{ route('barangay.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#barangayForm').trigger("reset");
                    table.draw();
                    if($('#savedata').html() == 'Save'){
                        toastr.success('Barangay added successfully','Success');
                    } else{
                        toastr.success('Barangay updated successfully','Success');
                    }
                    $('#addModal').modal('hide');

                },
                error: function (data) {
                    console.log('Error:', data);

                }
            });
        });
        
        // EDIT 
        $('body').on('click', '.editBarangay', function () {
            var id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{ url('admin/barangay/edit') }}",
                data:{
                id:id
                },
                success: function (data) {
                    $('#addModal').modal('show');
                    $('#id').val(id);
                    $('#barangayName').val(data.barangayName);
                    $('#barangayCaptain').val(data.barangayCaptain);
                    $('#savedata').html('Update');
                    $('.modal-title').html('Update Barangay');
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
