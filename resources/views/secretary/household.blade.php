@extends('layouts.secretary-sidebar')
<style>
    .sidebar-reports, .sidebar-households{
        color: rgb(180, 179, 179);
     }
 </style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Households</h4>

    <table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center" style="width: 10%">Household No.</td>
                <td class="text-center">Family Head</td>
                <td class="text-center" style="width: 15%">Zone</td>
                <td class="text-center">Mobile No.</td>
                {{-- <td class="text-center">Zone</td> --}}
            </tr>
        </thead>
        <tbody></tbody>
    </table>

{{-- add modal --}}
  <div class="modal modal-lg fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="residentForm" id="residentForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Resident Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                    <nav class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                        <a class="nav-link" id="nav-education-tab" data-bs-toggle="tab" href="#nav-education" role="tab" aria-controls="nav-education" aria-selected="false">Education</a>
                        <a class="nav-link" id="nav-work-tab" data-bs-toggle="tab" href="#nav-work" role="tab" aria-controls="nav-work" aria-selected="false">Work</a>
                        <a class="nav-link" id="nav-farm-tab" data-bs-toggle="tab" href="#nav-farm" role="tab" aria-controls="nav-farm" aria-selected="false">Farm</a>
                        <a class="nav-link" id="nav-business-tab" data-bs-toggle="tab" href="#nav-business" role="tab" aria-controls="nav-business" aria-selected="false">Business</a>
                        <a class="nav-link" id="nav-vehicles-tab" data-bs-toggle="tab" href="#nav-vehicles" role="tab" aria-controls="nav-vehicles" aria-selected="false">Vehicles</a>
                        <a class="nav-link" id="nav-gadgets-tab" data-bs-toggle="tab" href="#nav-gadgets" role="tab" aria-controls="nav-gadgets" aria-selected="false">Gadgets</a>
                        <a class="nav-link" id="nav-calamity-tab" data-bs-toggle="tab" href="#nav-calamity" role="tab" aria-controls="nav-calamity" aria-selected="false">Calamity</a>
                        <a class="nav-link" id="nav-others-tab" data-bs-toggle="tab" href="#nav-others" role="tab" aria-controls="nav-others" aria-selected="false">Others</a>


                        {{-- <a class="nav-link disabled" id="nav-disabled-tab" data-bs-toggle="tab" href="#nav-disabled" role="tab" aria-controls="nav-disabled" tabindex="-1" aria-disabled="true">Disabled</a> --}}
                      </nav>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-education-tab">

                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-6">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control text-capitalize" name="name" id="name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="gender" class="form-label">Gender:</label>
                                    <select class="form-select" aria-label="Default select example" name="gender" id="gender">
                                        <option selected>Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Others</option>
                                      </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="family_no" class="form-label">Family No.:</label>
                                    <input type="text" class="form-control text-end" name="family_no" id="family_no">
                                </div>
                            </div>
                            <div class="row form-row mb-3 mt-1 fw-bold">
                                <div class="form-group col-md-4">
                                    <label for="civil status" class="form-label text-capitalize">civil status:</label>
                                    <select class="form-select" aria-label="Default select example" name="civil_status" id="civil_status">
                                        <option selected>Select status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Single Parent">Single Parent</option>
                                        <option value="Divorced">Divorced</option>
                                       
                                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="birthday" class="form-label text-capitalize">date of birth:</label>
                                    <input type="date" class="form-control" name="birthday" id="birthday">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="age" class="form-label disabled">Age:</label>
                                    <input type="number" class="form-control text-end" name="age" id="age">
                                </div>
                            </div>
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-6">
                                    <label for="hf_relation" class="form-label text-capitalize">Head of Family Relation:</label>
                                    <input type="text" class="form-control" name="hf_relation" id="hf_relation">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="religion" class="form-label text-capitalize">religion:</label>
                                    <input type="text" class="form-control" name="religion" id="religion">
                                </div>
                            </div>
                            <div class="row form-row mb-3 mt-1 fw-bold">
                                <div class="form-group col-md-3">
                                    <label for="zone" class="form-label text-capitalize">Zone (purok)</label>
                                    <input type="text" class="form-control" name="zone" id="zone">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="barangay" class="form-label text-capitalize">barangay:</label>
                                    <input type="text" class="form-control" name="barangay" id="barangay">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="municipality" class="form-label text-capitalize">municipality:</label>
                                    <input type="text" class="form-control" name="municipality" id="municipality">
                                </div>

                            </div>
                            <div class="row form-row mt-1 fw-bold">
                                <div class="form-group col-md-6">
                                    <label for="province" class="form-label text-capitalize">province:</label>
                                    <input type="text" class="form-control" name="province" id="province">
                                </div>
                            </div>

                              {{-- <div class="row form-row mb-3 mt-2 fw-bold">
                              </div> --}}
                        </div>

                        <div class="tab-pane fade" id="nav-education" role="tabpanel" aria-labelledby="nav-education-tab">
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-6">
                                    <label for="educational_attainment" class="form-label">Educational Attainment:</label>
                                    <select class="form-select" aria-label="Default select example" name="educational_attainment" id="educational_attainment">
                                        <option selected>Select education</option>
                                        <option value="None">None</option>
                                        <option value="Elementary">Elementary</option>
                                        <option value="Junior High">Junior High</option>
                                        <option value="Senior High">Senior High</option>
                                        <option value="Vocational">Vocational</option>
                                        <option value="College">College</option>
                                        <option value="Post Graduate">Post Graduate</option>
                                      </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="eligibility" class="form-label">Eligibility : <span class="text-muted" style="font-size: 12px">(if any)</span></label>
                                    <input type="text" class="form-control" name="eligibility" id="eligibility">
                                </div>
                            </div>
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-8">
                                    <label for="reason_osy" class="form-label">Reason for not attending school</label>
                                    <select class="form-select" aria-label="Default select example" name="reason_osy" id="educational_attainment">
                                        <option selected>Select option</option>
                                        <option value="School are very far">School are very far</option>
                                        <option value="No school w/ in the barangay">No school w/ in the barangay</option>
                                        <option value="No regular transportaion">No regular transportaion</option>
                                        <option value="High cost of education">High cost of education</option>
                                        <option value="Illness / Disability">Illness/Disability</option>
                                        <option value="Housekeeping / taking care of siblings">Housekeeping/taking care of siblings</option>
                                        <option value="Marriage">Marriage</option>
                                        <option value="Employment / looking for work">Employment/looking for work</option>
                                        <option value="Lack of interest">Lack of interest</option>
                                        <option value="Cannot cope up w/ the school work">Cannot cope up w/ the school work</option>
                                        <option value="Finished schooling">Finished schooling</option>
                                        <option value="Problem of school record">Problem of school record</option>
                                        <option value="Problem with birth certificate">Problem with birth certificate</option>
                                        <option value="Others">Others</option>
                                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="eligibility" class="form-label">Computer Literate : </label>
                                    <select class="form-select" aria-label="Default select example" name="reason_osy" id="educational_attainment">
                                        <option selected>Select option</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                      </select>
                                </div>
                            </div>
                            <div class="row form-row mt-2 fw-bold">
                                <div class="form-group col-md-5">
                                    <label for="special_skill" class="form-label">Special Skill : <span class="text-muted" style="font-size: 12px">(if any)</span></label>
                                    <input type="text" class="form-control" name="special_skill" id="special_skill">
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-work" role="tabpanel" aria-labelledby="nav-work-tab">
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-6">
                                    <label for="occupation" class="form-label">Occupation:</label>
                                    <select class="form-select" aria-label="Default select example" name="occupation" id="occupation">
                                        <option selected>Select option</option>
                                        <option value="Farming">Farming</option>
                                        <option value="Teaching">Teaching</option>
                                        <option value="Business">Business</option>
                                        <option value="Engineer">Engineer</option>
                                        <option value="Farm Laborer">Farm Laborer</option>
                                        <option value="Driving">Driving</option>
                                        <option value="Electrician">Electrician</option>
                                        <option value="Office Worker">Office Worker</option>
                                        <option value="House Wife">House Wife</option>
                                        <option value="OFW">OFW</option>
                                        <option value="Barangay Official">Barangay Official</option>
                                        <option value="Security Guard">Security Guard</option>
                                        <option value="Others">Others</option>
                                      </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="employment_nature" class="form-label">Nature of Employment:</label>
                                    <select class="form-select" aria-label="Default select example" name="employment_nature" id="employment_nature">
                                        <option selected>Select option</option>
                                        <option value="Contractual">Contractual</option>
                                        <option value="Job Order">Job Order</option>
                                        <option value="Permanent">Permanent</option>
                                        <option value="Seasonal">Seasonal</option>
                                        <option value="Freelancer">Freelancer</option>
                                        <option value="Others">Others</option>
                                      </select>
                                </div>
                            </div>
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-7">
                                    <label for="work_place" class="form-label">Place of Work:</label>
                                    <input type="text" class="form-control" name="work_place" id="work_place">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="monthly_income" class="form-label">Monthly Income:</label>
                                    <input type="text" class="form-control text-end" name="monthly_income" id="monthly_income">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-farm" role="tabpanel" aria-labelledby="nav-farm-tab">
                            <div class="row form-row mb-3 mt-3 fw-bold">
                                <div class="form-group col-md-3">
                                    <label for="rice_area" class="form-label">Rice Area:</label>
                                    <input type="text" class="form-control text-capitalize" name="rice_area" id="rice_area">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="rice_location" class="form-label">Location:</label>
                                    <input type="text" class="form-control text-capitalize" name="rice_location" id="rice_location">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="farm_type" class="form-label">Farm type:</label>
                                    <select class="form-select" aria-label="Default select example" name="farm_type" id="farm_type">
                                        <option selected>Select option</option>
                                        <option value="Irrigated">Irrigated</option>
                                        <option value="Watershed">Watershed</option>
                                      </select>
                                </div>
                            </div>
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-3">
                                    <label for="farm_flooded" class="form-label">Farm flooded:</label>
                                    <input type="text" class="form-control text-capitalize" name="farm_flooded " id="farm_flooded  ">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="rice_ownership_status" class="form-label">Ownership status:</label>
                                    <input type="text" class="form-control text-capitalize" name="rice_ownership_status " id="rice_ownership_status  ">
                                </div>
                            </div>

                            <div class="row form-row mb-3 mt-3 fw-bold">
                                <div class="form-group col-md-3">
                                    <label for="corn_area" class="form-label">Corn Area:</label>
                                    <input type="text" class="form-control text-capitalize" name="corn_area" id="corn_area">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="corn_location" class="form-label">Location:</label>
                                    <input type="text" class="form-control text-capitalize" name="corn_location" id="corn_location">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="corn_ownership_status" class="form-label">Ownership status:</label>
                                    <input type="text" class="form-control text-capitalize" name="corn_ownership_status " id="corn_ownership_status  ">
                                </div>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">business.</div>
                        <div class="tab-pane fade" id="nav-vehicles" role="tabpanel" aria-labelledby="nav-vehicles-tab">vehicles.</div>
                        <div class="tab-pane fade" id="nav-gadgets" role="tabpanel" aria-labelledby="nav-gadgets-tab">gadgets.</div>
                        <div class="tab-pane fade" id="nav-calamity" role="tabpanel" aria-labelledby="nav-calamity-tab">calamity.</div>
                        <div class="tab-pane fade" id="nav-others" role="tabpanel" aria-labelledby="nav-others-tab">others.</div>
                        {{-- <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium minima repellat incidunt facilis obcaecati blanditiis corrupti ad officia doloribus ullam sapiente ipsum, nemo a, excepturi voluptatem voluptatibus velit eum dignissimos ut, nam tempora? Reiciendis illo itaque veritatis eligendi fuga, mollitia ratione totam veniam esse in.</div> --}}
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


  {{-- VIEW modal --}}
  <div class="modal modal-lg fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="residentForm" id="residentForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> Resident Details <i class="bi-info-circle"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    {{-- hidden id --}}
                    <input type="hidden" name="id" id="id">
                    <nav class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-view-profile-tab" data-bs-toggle="tab" href="#nav-view-profile" role="tab" aria-controls="nav-view-profile" aria-selected="false">Profile</a>
                        <a class="nav-link" id="nav-view-education-tab" data-bs-toggle="tab" href="#nav-view-education" role="tab" aria-controls="nav-view-education" aria-selected="false">Education</a>
                        <a class="nav-link" id="nav-view-work-tab" data-bs-toggle="tab" href="#nav-view-work" role="tab" aria-controls="nav-view-work" aria-selected="false">Work</a>
                        <a class="nav-link" id="nav-view-area-tab" data-bs-toggle="tab" href="#nav-view-area" role="tab" aria-controls="nav-view-area" aria-selected="false">Area</a>
                        <a class="nav-link" id="nav-view-business-tab" data-bs-toggle="tab" href="#nav-view-business" role="tab" aria-controls="nav-view-business" aria-selected="false">Business</a>
                        <a class="nav-link" id="nav-view-vehicles-tab" data-bs-toggle="tab" href="#nav-view-vehicles" role="tab" aria-controls="nav-view-vehicles" aria-selected="false">Vehicles</a>
                        <a class="nav-link" id="nav-view-gadgets-tab" data-bs-toggle="tab" href="#nav-view-gadgets" role="tab" aria-controls="nav-view-gadgets" aria-selected="false">Gadgets</a>
                        <a class="nav-link" id="nav-view-calamity-tab" data-bs-toggle="tab" href="#nav-view-calamity" role="tab" aria-controls="nav-view-calamity" aria-selected="false">Calamity</a>
                        <a class="nav-link" id="nav-view-others-tab" data-bs-toggle="tab" href="#nav-view-others" role="tab" aria-controls="nav-view-others" aria-selected="false">Others</a>


                        {{-- <a class="nav-link disabled" id="nav-disabled-tab" data-bs-toggle="tab" href="#nav-disabled" role="tab" aria-controls="nav-disabled" tabindex="-1" aria-disabled="true">Disabled</a> --}}
                      </nav>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-view-profile" role="tabpanel" aria-labelledby="nav-view-education-tab">
                            <div class="mb-3">
                                <label for="barangayName" class="form-label">Barangay</label>
                                <input type="text" class="form-control text-capitalize" name="barangayName" id="barangayName" placeholder="dalin">
                            </div>
                            <div class="mb-3">
                                <label for="barangayCaptain" class="form-label">Barangay Captain</label>
                                <input type="text" class="form-control text-capitalize" name="barangayCaptain" id="barangayCaptain" placeholder="Juan Dela Cruz">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-view-education" role="tabpanel" aria-labelledby="nav-view-ducation-tab">Lorem ipsum dolor sit amet, consveritatis.</div>
                        <div class="tab-pane fade" id="nav-view-work" role="tabpanel" aria-labelledby="nav-view-work-tab">Loatis.</div>
                        <div class="tab-pane fade" id="nav-view-area" role="tabpanel" aria-labelledby="nav-view-area-tab">Area.</div>
                        <div class="tab-pane fade" id="nav-view-business" role="tabpanel" aria-labelledby="nav-view-business-tab">business.</div>
                        <div class="tab-pane fade" id="nav-view-vehicles" role="tabpanel" aria-labelledby="nav-view-vehicles-tab">vehicles.</div>
                        <div class="tab-pane fade" id="nav-view-gadgets" role="tabpanel" aria-labelledby="nav-view-gadgets-tab">gadgets.</div>
                        <div class="tab-pane fade" id="nav-view-calamity" role="tabpanel" aria-labelledby="nav-view-calamity-tab">calamity.</div>
                        <div class="tab-pane fade" id="nav-view-others" role="tabpanel" aria-labelledby="nav-view-others-tab">others.</div>
                        {{-- <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium minima repellat incidunt facilis obcaecati blanditiis corrupti ad officia doloribus ullam sapiente ipsum, nemo a, excepturi voluptatem voluptatibus velit eum dignissimos ut, nam tempora? Reiciendis illo itaque veritatis eligendi fuga, mollitia ratione totam veniam esse in.</div> --}}
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

        //load table
        let table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            select: true,
            ajax: "{{ route('household') }}",
            deferRender: true,
            columns: [
                {data: 'household_no', name: 'household_no'},
                {data: 'name', name: 'name'},
                {data: 'zone', name: 'zone', class: 'text-end'},
                // {data: 'zone', name: 'zone', render: function(data, type, full, meta) {return "Zone" + " " +  "0"+  data}},
                {data: 'cp_number', name: 'cp_number', class: 'text-end'},
                // {data: 'zone', name: 'zone'},
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
                        title: '<h3 class="text-center m-4">{!! $filter_setting->barangay !!} Households Summary Report</h3>'
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

        //show modal
            // SHOW ADD MODAL
        $('#addAccount').click(function () {
            $('#id').val('');
            $('#residentForm').trigger("reset");
            $('#addModal').modal('show');
            $('#savedata').html('Save');
        });

        //add function
        $('#savedata').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#residentForm').serialize(),
            url: "{{ route('resident.store')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#residentForm').trigger("reset");
                    $('#addModal').modal('hide');
                    table.draw();
                    toastr.success('Resident added successfully','Success');
                },
                error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                }
            });
        });

        // VIEW DETAILS
        $('body').on('click', '.viewResident', function () {
            var id = $(this).data('id');
            $.ajax({
                type:"GET",
                url: "{{ url('barangay/resident/show') }}",
                data: { id: id},
                dataType: 'json',
                    success: function(data){
                        $('#viewModal').modal('show');
                        // $('#view_id').val(data.id);
                        // $('#view_lastname').val(data.lastname);
                        // $('#view_firstname').val(data.firstname);

                    }
            });
        });

        // DELETE 
        $('body').on('click', '.deleteResident', function () {
        var id = $(this).data("id");
            if (confirm("Are You sure want to delete this resident?") === true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('barangay/resident/destroy') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Resident deleted successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });

        $('#submenu3').addClass('show').removeClass('hide');
    }); //end of script


    // calculation of age


    $('#birthday').change(function(){
        var today = new Date();
        var birthDate = new Date($('#birthday').val());
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
        return $('#age').val(age);
    });
</script>

@endsection
