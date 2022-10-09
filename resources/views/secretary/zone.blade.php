@extends('layouts.secretary-sidebar')
<style>
   .sidebar-brgy{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"><i class="bi-person-bounding-box"></i> Zone Lists</h4>

    <table class="table table-bordered data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Zone Name</td>
                <td class="text-center">No. of residents</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="zoneForm" id="zoneForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Zone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                  <div class="mb-3">
                      <label for="zone" class="form-label">Zone:</label>
                      <input type="text" class="form-control text-capitalize" name="zone" id="zone" placeholder="e.g. Zone 01 , Purok Mangga, Purok 2">
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
            responsive: true,
            select: true,
            ajax: "{{ route('barangay.zone') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'zone', name: 'zone'},
                {data: 'per_zone', name: 'per_zone', class: 'text-end'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="bi-plus-circle text-ce"></i> Add',
                    className: 'badge bg-secondary fs-5 mb-2',
                    action: function(e, dt, node, config){
                        // show modal
                        $('#id').val('');
                        $('#zoneForm').trigger("reset");
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
            data: $('#zoneForm').serialize(),
            url: "{{ route('zone.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#zoneForm').trigger("reset");
                    table.draw();
                    toastr.success('Zone added successfully','Success');
                },
                error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');

                }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteZone', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this zone?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/zone/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Zone deleted successfully','Success');
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
