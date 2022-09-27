@extends('layouts.secretary-sidebar')
<style>
    #resident, #residentIcon {
        background-color: gray;
    }
</style>
@section('content')
    <span class="badge bg-primary fs-4 mb-3">Barangay Officials</span>
    <!-- Button trigger modal -->
    <div class="d-flex flex-row-reverse bd-highlight">
        <!-- Button trigger modal -->
        <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm mb-2" btn-sm id="addAccount"><i class="bi-plus-square ">  </i> Add Official</a>
    </div>
    <table class="table table-bordered data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Position</td>
                <td class="text-center">Name</td>
                <td class="text-center">Zone</td>
                <td class="text-center">Service Tenure</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

{{-- add modal --}}
  <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="accountForm" id="accountForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Resident</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                    <nav class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                        <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                        <a class="nav-link disabled" id="nav-disabled-tab" data-bs-toggle="tab" href="#nav-disabled" role="tab" aria-controls="nav-disabled" tabindex="-1" aria-disabled="true">Disabled</a>
                      </nav>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid tempore tempora molestiae pariatur, voluptate fuga corrupti est reiciendis maxime totam dolores, voluptates, dolorem eaque sequi.</div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni, natus sed soluta necessitatibus tempore aspernatur? Praesentium, odit explicabo distinctio dolore adipisci officia iure, ut magnam optio aliquam at similique veritatis.</div>
                        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium minima repellat incidunt facilis obcaecati blanditiis corrupti ad officia doloribus ullam sapiente ipsum, nemo a, excepturi voluptatem voluptatibus velit eum dignissimos ut, nam tempora? Reiciendis illo itaque veritatis eligendi fuga, mollitia ratione totam veniam esse in.</div>
                      </div>
                    <div class="mb-3">
                        <label for="barangaySecretary" class="form-label">Barangay Secretary</label>
                        <input type="text" class="form-control text-capitalize" name="barangaySecretary" id="barangaySecretary" placeholder="Juan Dela Cruz">
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
            responsive: true,
            select: true,
            ajax: "{{ route('barangay.officials') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'position', name: 'position'},
                {data: 'name', name: 'name'},
                {data: 'official_committee', name: 'official_committee'},
                {data: 'year_of_service', name: 'year_of_service'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
    //         columnDefs: [ 
    //       {
    //         'targets': 1,
    //         'render': function(data, type, row){
    //           return data +', '+row.firstName+' ' +row.middleName;
    //         },
    //         'targets': 1
    //     }
    //   ]
        });

        //show modal
            // SHOW ADD MODAL
        $('#addAccount').click(function () {
            $('#id').val('');
            $('#accountForm').trigger("reset");
            $('#addModal').modal('show');
            $('#savedata').html('Save');
        });

        //add function
        $('#savedata').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#accountForm').serialize(),
            url: "{{ route('account.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#accountForm').trigger("reset");
                    $('#addModal').modal('hide');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);

                }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteAccount', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this account?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/account/destroy') }}",
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
