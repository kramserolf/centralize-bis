@extends('layouts.secretary-sidebar')
<style>
   .sidebar-certificate, .sidebar-certificate{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Issued Certificates</h4>

    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Name</td>
                <td class="text-center">Zone</td>
                <td class="text-center">Certificate Type</td>
                <td class="text-center">Purpose</td>
                <td class="text-center">Date Requested</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="overlay"></div>
<script>
    
    $(document).ready(function(){
        // $('#barangay').trigger('click');

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // TOASTR OPTIONS
        toastr.options = {
            "debug": false,
            "newestOnTop": true,
            "preventDuplicates": true
        }

        //load table
        let table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            select: true,
            ajax: "{{ route('certificate.requests') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'zone', name: 'zone'},
                {data: 'certificate', name: 'certificate'},
                {data: 'purpose', name: 'purpose'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', class: 'text-center'},
            ],
            dom: 'fBrtlip',
            buttons: [
                'colvis',
                {
                    extend: 'spacer',
                    text: 'Export Files',
                    style: 'bar',

                },
                {
                    extend: 'print',

                    repeatingHead: {
                        logo: '{{ asset('images/barangay_logo/'.$filter_setting->logo.'') }}',
                        logoPosition: 'center',
                        logoStyle: 'width: 90',
                        title: '<h3 class="text-center m-4">{!! $filter_setting->barangay !!} Issued Certificates Summary Report</h3>'
                    },
                    title: '',
                },
                'spacer',
                {
                    extend: 'pdf',
                    columns: [1,2,3,4]
                }

            ],
   
        });

    // issue certificate
    $('body').on('click', '.approveRequest', function(){
        var id = $(this).data('id');

 
        if(confirm("Are you sure you want to approve this request?") == true){
            $.ajax({
                type: "POST",
                url: "{{ route('approve.certificate') }}",
                dataType: 'json',
                data: {id:id},
                success: function (data) {
                    toastr.success('Certificate approved successfully','Success');
                    table.draw();
                    window.location.href = "{{ route('certificate.reports') }}";
                },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                }
            });
        }
    });

        // DELETE 
        $('body').on('click', '.deleteRequest', function () {
        var id = $(this).data("id");
            if (confirm("Are you sure want to reject this request?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/certificates/request/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Request deleted successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });
        $('#submenu3').addClass('show').removeClass('hide');
        

    }); //end of script

    $(document).on({
        ajaxStart: function(){
            $('body').addClass('loading');
        },
        ajaxStop: function(){
            $('body').removeClass('loading');
        }
    });

</script>

@endsection
