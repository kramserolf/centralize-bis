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
                <td class="text-center">Date Issued</td>
                <td class="text-center">Download</td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="barangayOfficialForm" id="barangayOfficialForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Barangay Official</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                  <div class="mb-3">
                      <label for="position" class="form-label">Position</label>
                      <input type="text" class="form-control text-capitalize" name="position" id="position" placeholder="Barangay Captain">
                  </div>
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control text-capitalize" name="name" id="name" placeholder="Juan Dela Cruz">
                  </div>

                  <div class="mb-3">
                    <label for="committee" class="form-label">Committee <span class="text-muted" style="font-size: 12pxl">(optional)</span></label>
                    <input type="text" class="form-control text-capitalize" name="committee" id="committee" placeholder="Community Engagement">
                  </div>

                  <div class="row form-row mb-3">
                    <div class="form-group col-md-6">
                        <label for="zone" class="form-label">Area Zone </span></label>
                            <select class="form-select" aria-label="Default select example" name="zone" id="zone">
                                <option selected>Select option</option>
                                @foreach ($filter_zone as $item)
                                <option value="{{$item->zone}}">{{$item->zone}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="years_of_service" class="form-label">Service Tenure</label>
                        <input type="text" class="form-control" name="years_of_service" id="years_of_service" placeholder="e.g 2020-Ongoing , 3 years" >
                    </div>
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
            ajax: "{{ route('certificate.reports') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'zone', name: 'zone'},
                {data: 'certificate', name: 'certificate'},
                {data: 'purpose', name: 'purpose'},
                {data: 'issue_date', name: 'issue_date'},
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

        // $('body').on('click', '.downloadCertificate', function(){
        //     var id = $(this).data('id');
        //     var data = "";
        //     $.ajax({
        //         url: '{{ url("barangay/certificate/download") }}',
        //         type: 'GET',
        //         data: data,
        //         xhrFields: {
        //             responseType: 'blob'
        //         },
        //         success: function(data){
        //             var blob = new Blob([data]);
        //             var link = document.createElement('a');
        //             link.href = window.URL.createObjectURL(blob);
        //             link.download = '2022-11-26Jhanel.docx';
        //             link.click();
        //         },
        //         error: function(data){
        //             alert(data);
        //         }
        //     });
        // });

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
