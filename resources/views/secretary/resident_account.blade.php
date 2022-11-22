@extends('layouts.secretary-sidebar')
<style>
   .sidebar-brgy, .sidebar-accounts{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary">Resident Accounts</h4>

    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Name</td>
                <td class="text-center">Email</td>
                <td class="text-center">Zone</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

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
            ajax: "{{ route('barangay.resident_account') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'zone', name: 'zone'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
        });

        // DELETE 
        $('body').on('click', '.deleteResidentAccount', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this account?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/resident-account/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Account deleted successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });
        $('#submenu1').addClass('show').removeClass('hide');
    }); 
    //end of script

</script>

@endsection
