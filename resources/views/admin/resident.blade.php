@extends('layouts.admin-sidebar')
<style>
    #resident {
        background-color: gray;
    }
</style>
@section('content')
    <span class="badge bg-secondary fs-4 mb-3 mt-2">Lists of Residents</span>
    <!-- Button trigger modal -->
    <div class="d-flex flex-row-reverse bd-highlight">
        <!-- Button trigger modal -->
        <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm mb-2" btn-sm id="addAccount"><i class="bi-plus-square ">  </i> Add Resident</a>
    </div>
    <table class="table table-bordered data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Name</td>
                <td class="text-center">Mobile No.</td>
                <td class="text-center">Barangay</td>
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
            ajax: "{{ route('admin.resident') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'lastName', name: 'lastName'},
                {data: 'mobileNumber', name: 'mobileNumber'},
                {data: 'barangay', name: 'barangay'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
            columnDefs: [ 
          {
            'targets': 1,
            'render': function(data, type, row){
              return data +', '+row.firstName;
            },
            'targets': 1
        }
      ]
        });
    }); //end of script

</script>

@endsection
