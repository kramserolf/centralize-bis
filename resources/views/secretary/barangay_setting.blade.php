@extends('layouts.secretary-sidebar')
<style>
    #brgySetting {
        background-color: gray;
    }
</style>
@section('content')
<span class="badge bg-primary fs-4 mb-3">Settings</span>
<div class="row m-4">
    <div class="col-xl-6">
        <form action="{{route('update.setting')}}" method="POST"  name="barangaySettingForm" id="barangaySettingForm" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header bg-secondary text-white fs-5">
                    Barangay Setting
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Barangay Logo <span class="text-muted" style="font-size: 12px;">Max dimension: <strong>900px</strong></span></label>
                        <input type="file" class="form-control" id="image" aria-describedby="image" name="image">
                        <div id="emailHelp" class="form-text">Make your image circular for better display.</div>
                      </div>
                      <div class="mb-3">
                        <label for="barangay_captain" class="form-label fw-bold">Barangay Captain<span class="text-muted" style="font-size: 12px;"> (optional)</span></label>
                        <input type="text" class="form-control" id="barangay_captain" placeholder="e.g Juan Dela Cruz">
                      </div>
                      <div class="mb-3">
                            <label for="municipality" class="form-label fw-bold">Municipality<span class="text-muted" style="font-size: 12px;"> (optional)</span></label>
                        <input type="text" class="form-control" id="municipality" placeholder="e.g Baggao">
                      </div>
                      <div class="mb-3">
                        <label for="province" class="form-label fw-bold">Barangay Captain<span class="text-muted" style="font-size: 12px;"> (optional)</span></label>
                        <input type="text" class="form-control" id="province" placeholder="e.g Cagayan">
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
        $('#barangaySettingForm').submit(function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('update.setting') }}",
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
