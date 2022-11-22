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
