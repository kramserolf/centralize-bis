@extends('layouts.admin-sidebar')
<style>
    .admin-reports{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Files</h4>
    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Barangay Name</td>
                <td class="text-center">Title</td>
                <td class="text-center">Remarks</td>
                <td class="text-center">Date Uploaded</td>
                <td class="text-center">Download</td>
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
            ajax: "{{ route('admin.reports') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'barangay', name: 'barangay'},
                {data: 'title', name: 'title'},
                {data: 'remarks', name: 'remarks'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
   
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
