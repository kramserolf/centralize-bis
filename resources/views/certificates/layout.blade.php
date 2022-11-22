@extends('layouts.secretary-sidebar')
<style>
    .sidebar-settings, .sidebar-layouts {
        color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary">Certificate Layouts</h4>
<table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
    <thead>
        <tr class="table-primary text-uppercase">
            <td class="text-center">No.</td>
            <td class="text-center">Certificate Type</td>
            <td class="text-center">Last updated at</td>
            <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>


{{-- add modal --}}
<div class="modal fade modal-lg" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('layout.store')}}"  method="post" name="certificateLayoutForm" id="certificateLayoutForm" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Barangay Official</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                    <div class="row form-row mb-3 mt-2 fw-bold">
                        <div class="form-group col-md-4">
                            <label for="cert_type" class="form-label">Certificate Type:</label>
                            <select class="form-select" aria-label="Default select example" name="cert_type" id="cert_type">
                                <option selected>Select option</option>
                                @foreach ($cert_type as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                            
                        <div class="form-group col-md-4">
                            <label for="logo1" class="form-label fw-bold">Logo 1 <span class="text-muted" style="font-size: 12px;">(left side)</span></label>
                            <input type="file" class="form-control" id="logo1" aria-describedby="logo1" name="logo1">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="logo2" class="form-label fw-bold">Logo 2 <span class="text-muted" style="font-size: 12px;">(right side)</span></label>
                            <input type="file" class="form-control" id="logo2" aria-describedby="logo2" name="logo2">
                        </div>
                    </div>
                    {{-- <div class="row form-row mb-3 mt-2 fw-bold">
                    </div> --}}

                    <div class="row form-row mb-3 mt-2 fw-bold">
                        <div class="form-group col-md-6">
                            <label for="cert_header" class="form-label fw-bold">Header</label>
                            <input type="text" class="form-control" id="cert_header" aria-describedby="cert_header" name="cert_header" placeholder="e.g OFFICE OF THE PUNONG BARANGAY">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cert_title" class="form-label fw-bold">Title</label>
                            <input type="text" class="form-control" id="cert_title" aria-describedby="cert_title" name="cert_title" placeholder="e.g CERTIFICATE OF RESIDENCY">
                        </div>
                    </div>
                    <div class="row form-row mb-3 mt-2 fw-bold">
                        <div class="form-group col-md-6">
                            <label for="paragraph1" class="form-label fw-bold">1st Paragraph</label>
                            <textarea class="form-control" id="paragraph1" name="paragraph1" rows="3" placeholder="e.g is a bonafide  resident of   Dalin,    Baggao,  Cagayan Located at (zone)"></textarea>
                            <span class="text-muted" style="font-size: 12px;">Note: do not fill zone</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="paragraph2" class="form-label fw-bold">2nd Paragraph</label>
                            <textarea class="form-control" id="paragraph2" name="paragraph2" rows="3" placeholder="e.g This certification is issued upon  the request of the above named-person for  general purposes."></textarea>
                        </div>
                    </div>
                    <div class="row form-row mb-3 mt-2 fw-bold">

                        <div class="form-group col-md-6">
                            <label for="paragraph3" class="form-label fw-bold">3rd Paragraph</label>
                            <textarea class="form-control" id="paragraph3" name="paragraph3" rows="3" placeholder="e.g. I further certify that this family has low income thus, they belong to the indigent families of this Barangay."></textarea>
                        </div>
                    </div>
                </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary" name="savedata" id="savedata" >Save</button>
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
            ajax: "{{ route('barangay.layout') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="bi-plus-circle text-ce"></i> Add',
                    className: 'btn btn-success btn-sm',
                    action: function(e, dt, node, config){
                        // show modal
                        $('#id').val('');
                        $('#certificateLayoutForm').trigger("reset");
                        $('#addModal').modal('show');
                        $('#savedata').html('Save');
                    },
                }
            ]
   
        });


        //add function
        $('#certificateLayoutForm').submit(function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('layout.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if(response){
                        this.reset();
                        toastr.success('Settings updated successfully','Success');
                        setTimeout(() => {
                            location.reload(true);
                        }, 1500);
                    }
                },
                error: function(response){
                    toastr.error(response['responseJSON']['message'],'Error has occured');
                }
            });
        });
        $('#submenu4').addClass('show').removeClass('hide');
    });
</script>
@endsection
