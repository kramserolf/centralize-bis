@extends('layouts.secretary-sidebar')
<style>
   .sidebar-reports, .sidebar-senior{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Senior Citizens</h4>

    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Household No.</td>
                <td class="text-center">Name</td>
                <td class="text-center">Age</td>
                <td class="text-center">Disability</td>
                <td class="text-center">Zone</td>
                {{-- <td class="text-center">Action</td> --}}
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    @include('modal.household')
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
            ajax: "{{ route('senior') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'household_no', name: 'household_no', class: 'text-center', render: function(data, type, row, meta){
                    return '<a id="household" role=""button href="#">'+row.household_no+'</a>'
                }},
                {data: 'name', name: 'name'},
                {data: 'age', name: 'age', class: 'text-center'},
                {data: 'disability',
                render: function(data){
                    return data == '1' ? 'Applicable' : '';
                }
            },
                {data: 'zone', name: 'zone', class: 'text-end'},
                // {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
            dom: 'fBrtlip',
            buttons: [
                {
                extend: 'print',

                repeatingHead: {
                    logo: '{{ asset('images/barangay_logo/'.$filter_setting->logo.'') }}',
                    logoPosition: 'center',
                    logoStyle: 'width: 90',
                    title: '<h3 class="text-center m-4">{!! $filter_setting->barangay !!} Senior Citizen Summary Report</h3>'
                },
                title: '',
            },
            {
                    extend: 'spacer',
                    text: 'Export Files',
                    style: 'bar',

                },
                'spacer',
                {
                    extend: 'pdf',
                    columns: [1,2,3,4]
                }

            ],
   
        });

        $('.household-close').click(function(){
            $('#result').empty();
        });

      //add function
      $('#savedata').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#barangayOfficialForm').serialize(),
            url: "{{ route('official.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#barangayOfficialForm').trigger("reset");
                    $('#addModal').modal('hide');
                    table.draw();
                    toastr.success('Barangay official added successfully','Success');
                },
                error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');

                }
            });
        });

        // view household members
        $('body').on('click', '#household', function(){
            var household_id= $(this).html();
            var id = parseInt(household_id);
            $.ajax({
                type:"GET",
                url: "{{ url('barangay/household/members') }}",
                data: { id: id},
                dataType: 'json',
                    success: function(data){
                        console.log(data);
                        $('#viewModal').modal('show');
                        $.each(data.result, function(index, value){
                            $('#result').append('<tr><td>'+ value['name'] +'</td><td class="text-center">'+value['age']+'</td><td class="text-center">'+value['gender']+'</td><td class="text-center">'+value['civil_status']+'</td><td class="text-end">'+value['cp_number']+'</td></tr>');
                        });
                        $('.modal-title').html('Household'+ ' ' + '<span class="text-primary">#'+ id+'</span>'+ ' ' + 'Members');
                }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteBarangayOfficial', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this barangay official?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/officials/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Barangay official deleted successfully','Success');
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
