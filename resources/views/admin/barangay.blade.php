@extends('layouts.admin-sidebar')
<style>
    #brgy, #brgyIcon {
        background-color: gray;
    }
</style>
@section('content')
    <span class="badge bg-info fs-4 mb-3 mt-2">Lists of Barangay</span>
    <!-- Button trigger modal -->
    <div class="d-flex flex-row-reverse bd-highlight">
        <!-- Button trigger modal -->
        <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm mb-2" btn-sm id="addBarangay"><i class="bi-plus-square ">  </i> Add Barangay</a>
    </div>
    <table class="table table-bordered data-table nowrap" style="width: 100%;">
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
            // responsive: {
            //     details: {
            //         display: $.fn.dataTable.Responsive.display.modal( {
            //             header: function (row) {
            //                 var data = row.data();
            //                 return 'Details of '+data['barangayName'];
            //             }
            //         } ),
            //         renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
            //             tableClass: 'data-table'
            //         } )
            //     }
            // },
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
                },
                error: function (data) {
                    console.log('Error:', data);

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
                    // toastr.success('Expense deleted successfully','Success');
                    },
                    error: function (data) {
                    // toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });

    }); //end of script

</script>

@endsection
