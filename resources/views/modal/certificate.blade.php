  {{-- certificate modal --}}
  <div class="modal fade" id="certificateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="certificateForm" id="certificateForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> Request Certificate/Clearance <i class="bi-info-circle"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    <div class="form-group col-md-12 mb-3">
                        <label for="cert_type" class="form-label fw-bold">Type of Certificate:</label>
                        <select class="form-select" aria-label="Default select example" name="cert_type" id="cert_type">
                            <option selected>Select option</option>
                            @foreach ($certificates as $item)
                            <option value="{{$item->id}}">{{$item->name}} </option>
                            @endforeach
                          </select>
                    </div>
                    <div class="form-group focused col-md-12 mb-3">
                      <label class="form-control-label fw-bold" for="current_password">Purpose: </label>
                      <input type="text" id="purpose" class="form-control" name="purpose" placeholder="e.g Scholarship">
                  </div>
                

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" name="savedata" id="savedata" >Submit</button>
                  <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
              </div>
        </form>
      </div>
    </div>
  </div>

  
  <script>
    $(document).ready(function(){
        $('.request').on('click', function(){
            $('#certificateModal').modal('show');
        });
    });
  </script>