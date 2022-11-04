@extends('layouts.secretary-sidebar')
<style>
   .sidebar-issuance{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Issue Certificate</h4>

    <table class="table table-bordered data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center" style="width: 10%;" id="household">Household No.</td>
                <td class="text-center" >Name</td>
                <td class="text-center">Zone</td>
                <td class="text-center" >Mobile No.</td>
                <td class="text-center" style="width: 15%;">Issue Certificate</td>
                
            </tr>
        </thead>
        <tbody></tbody>
    </table>

  {{-- certificate modal --}}
  <div class="modal fade" id="certificateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="certificateForm" id="certificateForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> Issue Certificate <i class="bi-info-circle"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input hidden  name="resident_id" id="resident_id">
                    <input hidden  type="text" name="resident_name" id="resident_name">
                    <input hidden  type="text" name="barangay_id" id="barangay_id">
                    <div class="form-group col-md-12">
                        <label for="cert_type" class="form-label">Certificate Type:</label>
                        <select class="form-select" aria-label="Default select example" name="cert_type" id="cert_type">
                            <option selected>Select option</option>
                            @foreach ($certificate as $item)
                            <option value="{{$item->id}}">{{$item->name}} </option>
                            @endforeach
                          </select>
                    </div>
                

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" name="btn_issueCertificate" id="btn_issueCertificate" >Issue</button>
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
            ajax: "{{ route('get-certificate.layout') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'household_no', name: 'household_no'},
                {data: 'name', name: 'name'},
                {data: 'zone_name', name: 'zone_name'},
                {data: 'cp_number', name: 'cp_number'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
        });

      //add function
      $('#savedata').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#certificateTypeForm').serialize(),
            url: "{{ route('type.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#certificateTypeForm').trigger("reset");
                    $('#addModal').modal('hide');
                    table.draw();
                    toastr.success('Certificate type added successfully','Success');
                },
                error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');

                }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteCertificateType', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this certificate?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/certificate-types') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Certificate type deleted successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        })
  

            // get certificate
        $('body').on('click', '.issueCertificate', function () {
            var id = $(this).data('id');
            $.ajax({
                type:"GET",
                url: "{{ url('barangay/resident/select-certificate') }}",
                data: { id: id},
                dataType: 'json',
                    success: function(data){
                        $('#certificateModal').modal('show');
                        $('#resident_name').val(data.name);
                        $('#resident_id').val(data.id);
                        $('#barangay_id').val(data.barangayId);
                    }
            });
        });

        // issue certificate
              //add function
      $('#btn_issueCertificate').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#certificateForm').serialize(),
            url: "{{ route('issue-certificate.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#certificateForm').trigger("reset");
                    $('#certificateModal').modal('hide');
                    toastr.success('Certificate issued successfully','Success');
                    table.draw();
                },
                error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');

                }
            });
        });

    }); 
    //end of script

</script>

@endsection
