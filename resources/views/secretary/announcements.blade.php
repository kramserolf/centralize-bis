@extends('layouts.secretary-sidebar')
<style>
   .sidebar-announcement{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary">Announcements</h4>

    <table class="table table-bordered data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center">Event Date</td>
                <td class="text-center">Title</td>
                <td class="text-center">Content</td>
                <td class="text-center">Location</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('announcement.store')}}" method="POST" name="announcementForm" id="announcementForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                  <div class="mb-3">
                      <label for="title" class="form-label fw-bold">Title</label>
                      <input type="text" class="form-control" name="title" id="title" placeholder="e.g Subsidy Program">
                  </div>
                  <div class="mb-3">
                    <label for="content" class="form-label fw-bold">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="5" placeholder="e.g There will subsidy program this coming Tuesday, Octorber 22, 2022....."></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="location" class="form-label fw-bold">Location</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="e.g. Barangay Hall">
                  </div>
                  <div class="mb-3">
                    <label for="date" class="form-label fw-bold">Date</label>
                    <input type="date" class="form-control" name="date" id="date">
                  </div>

                  <div class="row form-row mb-3">
                    <div class="form-group col-md-12">
                       <label for="image" class="form-label fw-bold">Image <span class="text-muted" style="font-size: 12px">(optional)</span></label>
                      <input type="file" class="form-control" name="image" id="inputImage">
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
            ajax: "{{ route('barangay.announcement') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'date', name: 'date'},
                {data: 'title', name: 'title'},
                {data: 'content', name: 'content'},
                {data: 'location', name: 'location'},
                {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="bi-plus-circle text-ce"></i> Add',
                    className: 'badge bg-secondary fs-5 mb-2',
                    action: function(e, dt, node, config){
                        // show modal
                        $('#id').val('');
                        $('#announcementForm').trigger("reset");
                        $('#addModal').modal('show');
                        $('#savedata').html('Save');
                    },
                }
            ]
   
        });

      //add function
       //add function
       $('#announcementForm').submit(function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('announcement.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if(response){
                        this.reset();
                        $('#addModal').modal('hide');
                        table.draw();
                        toastr.success('Announcement added successfully','Success');
                        // setTimeout(() => {
                        //     location.reload(true);
                        // }, 1500);
                    }
                },
                error: function(response){
                    toastr.error(response['responseJSON']['message'],'Error has occured');
                }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteAnnouncement', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this announcement?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/announcement/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Announcement deleted successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });
    }); 
    //end of script

</script>

@endsection
