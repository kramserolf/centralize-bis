@extends('layouts.secretary-sidebar')
<style>
    .sidebar-settings {
        color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary">     Certificate Layouts</h4>
<div class="row m-4">
    <div class="col-xl-12">
        <form action="{{route('layout.store')}}" method="POST"  name="layoutForm" id="layoutForm" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header bg-secondary text-white fs-5">
                    Layouts
                </div>
                <div class="card-body">
                    <div class="row form-row mb-3 mt-2 fw-bold">
                        <div class="form-group col-md-4">
                            <label for="logo1" class="form-label fw-bold">Logo 1 <span class="text-muted" style="font-size: 12px;">(left side)</span></label>
                            <input type="file" class="form-control" id="logo1" aria-describedby="logo1" name="logo1">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="logo2" class="form-label fw-bold">Logo 2 <span class="text-muted" style="font-size: 12px;">(right side)</span></label>
                            <input type="file" class="form-control" id="logo2" aria-describedby="logo2" name="logo2">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cert_type" class="form-label">Certificate Type:</label>
                            <select class="form-select" aria-label="Default select example" name="cert_type" id="cert_type">
                                <option selected>Select option</option>
                                <option value="Residency">Residency</option>
                                <option value="Indigency">Indigency</option>
                                <option value="Scholarship">Scholarship</option>    
                                <option value="PWD">PWD</option>
                                <option value="Late Registration">Late Registration</option>
                                <option value="Good moral">Good moral</option>
                              </select>
                        </div>
                    </div>

                    <div class="row form-row mb-3 mt-2 fw-bold">
                        <div class="form-group col-md-4">
                            <label for="cert_header" class="form-label fw-bold">Header</label>
                            <input type="text" class="form-control" id="cert_header" aria-describedby="cert_header" name="cert_header" placeholder="e.g OFFICE OF THE PUNONG BARANGAY">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cert_title" class="form-label fw-bold">Title</label>
                            <input type="text" class="form-control" id="cert_title" aria-describedby="cert_title" name="cert_title" placeholder="e.g CERTIFICATE OF RESIDENCY">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cert_purpose" class="form-label fw-bold">Purpose</label>
                            <input type="text" class="form-control" id="cert_purpose" aria-describedby="cert_purpose" name="cert_purpose" placeholder="e.g CERTIFICATE OF RESIDENCY">
                        </div>
                        {{-- <div class="form-group col-md-4">
                            <label for="gender" class="form-label">Certificate Type:</label>
                            <select class="form-select" aria-label="Default select example" name="gender" id="gender">
                                <option selected>Select option</option>
                                <option value="Residency">Residency</option>
                                <option value="Indigency">Indigency</option>
                                <option value="Scholarship">Scholarship</option>    
                                <option value="PWD">PWD</option>
                                <option value="Late Registration">Late Registration</option>
                                <option value="Good moral">Good moral</option>
                              </select>
                        </div> --}}
                    </div>
                    <div class="row form-row mb-3 mt-2 fw-bold">
                        <div class="form-group col-md-5">
                            <label for="paragraph1" class="form-label fw-bold">1st Paragraph</label>
                            <textarea class="form-control" id="paragraph1" name="paragraph1" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="paragraph2" class="form-label fw-bold">2nd Paragraph</label>
                            <textarea class="form-control" id="paragraph2" name="paragraph2" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row form-row mb-3 mt-2 fw-bold">
                        <div class="form-group col-md-5">
                            <label for="paragraph3" class="form-label fw-bold">3rd Paragraph</label>
                            <textarea class="form-control" id="paragraph3" name="paragraph3" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="paragraph4" class="form-label fw-bold">4th Paragraph</label>
                            <textarea class="form-control" id="paragraph4" name="paragraph4" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-success" name="savedata" id="savedata">Save</button>
                  </div>
            </div>
          </form>
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
        //add function
        $('#layoutForm').submit(function(e){
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
    });
</script>
@endsection
