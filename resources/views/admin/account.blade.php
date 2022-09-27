@extends('layouts.admin-sidebar')
<style>
    #acct, #acctIcon {
        background-color: gray;
    }
</style>
@section('content')
    <span class="badge bg-primary fs-4 mb-3 mt-2">Lists of Accounts</span>
    <!-- Button trigger modal -->
    <div class="d-flex flex-row-reverse bd-highlight">
        <!-- Button trigger modal -->
        <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm mb-2" btn-sm id="addAccount"><i class="bi-plus-square ">  </i> Add Account</a>
    </div>
    <table class="table table-bordered data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Barangay</td>
                <td class="text-center">Name</td>
                <td class="text-center">Email</td>
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
                <h5 class="modal-title" id="staticBackdropLabel">New Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                <div class="mb-3">
                      <label for="barangay_id" class="form-label">Barangay</label>
                      <select class="form-select" aria-label="Default select example" name="barangay_id" id="barangay_id">
                        <option selected>Select Barangay</option>
                        @foreach ($barangays as $item)
                            <option value="{{$item->id}}">{{$item->barangayName}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="mb-3">
                      <label for="name" class="form-label">Name </label>
                      <input type="text" class="form-control text-capitalize" name="name" id="name" placeholder="Juan Dela Cruz">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="e.g@gmail.com, e.g@yahoo.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact No.</label>
                    <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="09563459871">
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
            ajax: "{{ route('account') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'barangay', name: 'barangay'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
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
