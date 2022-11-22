@extends('layouts.secretary-sidebar')
<style>
    .sidebar-brgy, .sidebar-residents{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary">Residents</h4>

    <table class="table table-bordered table-sm data-table nowrap w-100">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center">No.</td>
                <td class="text-center" style="width: 10%;" id="household">Household No.</td>
                <td class="text-center" >Name</td>
                <td class="text-center">Zone</td>
                <td class="text-center" >Mobile No.</td>
                {{-- <td class="text-center">Zone</td> --}}
                <td class="text-center" style="width: 15%;">Action</td>
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
                        <a class="nav-link" id="nav-utilities-tab" data-bs-toggle="tab" href="#nav-utilities" role="tab" aria-controls="nav-utilities" aria-selected="false">Utilities</a>

                        <a class="nav-link" id="nav-calamity-tab" data-bs-toggle="tab" href="#nav-calamity" role="tab" aria-controls="nav-calamity" aria-selected="false">Calamity</a>
                        <a class="nav-link" id="nav-others-tab" data-bs-toggle="tab" href="#nav-status" role="tab" aria-controls="nav-status" aria-selected="false">Status</a>


                        {{-- <a class="nav-link disabled" id="nav-disabled-tab" data-bs-toggle="tab" href="#nav-disabled" role="tab" aria-controls="nav-disabled" tabindex="-1" aria-disabled="true">Disabled</a> --}}
                      </nav>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-education-tab">

                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-5">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control text-capitalize" name="name" id="name">
                                </div>
                                <div class="form-group col-md-3">
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
                                <div class="form-group col-md-2">
                                    <label for="household_no" class="form-label">Household No.:</label>
                                    <input type="text" class="form-control text-end" name="household_no" id="household_no">
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
                            <div class="row form-row mt-1 fw-bold">
                                <div class="form-group col-md-4">
                                    <label for="zone" class="form-label">Area Zone </span></label>
                                    <select class="form-select" aria-label="Default select example" name="zone" id="zone">
                                        <option selected>Select option</option>
                                        @foreach ($filter_zone as $item)
                                        <option value="{{$item->zone}}">{{$item->zone}}</option>
                                        @endforeach
                                    </select>
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
                        <div class="tab-pane fade" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-4">
                                    <h4>Business</h4>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="poultry" id="poultry" name="poultry">
                                        <label class="form-check-label" for="poultry">
                                          Poultry
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="livestock" id="livestock" name="livestock">
                                        <label class="form-check-label" for="livestock">
                                          Livestock
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="fishery" id="fishery" name="fishery">
                                        <label class="form-check-label" for="fishery">
                                          Fishery
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="store" id="store" name="store">
                                        <label class="form-check-label" for="store">
                                          Store
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Vehicles</h4>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="motorcycle" id="motorcycle" name="motorcycle">
                                        <label class="form-check-label" for="motorcycle">
                                          Motorcycle
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="tricycle" id="tricycle" name="tricycle">
                                        <label class="form-check-label" for="tricycle">
                                          Tricycle
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="van" id="van" name="van">
                                        <label class="form-check-label" for="van">
                                          Van
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="truck" id="truck" name="truck">
                                        <label class="form-check-label" for="truck">
                                          Truck
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="kuliglig" id="kuliglig" name="kuliglig">
                                        <label class="form-check-label" for="kuliglig">
                                          Kuliglig
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="ripper" id="ripper" name="ripper">
                                        <label class="form-check-label" for="ripper">
                                          Ripper
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="tractor" id="tractor" name="tractor">
                                        <label class="form-check-label" for="tractor">
                                          Tractor
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-utilities" role="tabpanel" aria-labelledby="nav-utilities-tab">Utilities</div>
                        <div class="tab-pane fade" id="nav-calamity" role="tabpanel" aria-labelledby="nav-calamity-tab">
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-6">
                                    <h5>Experience Drought?</h5>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="experience_drought" id="experience_drought" value="1">
                                        <label class="form-check-label" for="experience_drought">
                                          Yes
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="experience_drought" id="experience_drought" value="2">
                                        <label class="form-check-label" for="experience_drought">
                                          No
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <h5>Experience Typhoon Evacuation?</h5>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="experience_evacuation" id="experience_evacuation" value="1">
                                        <label class="form-check-label" for="experience_evacuation">
                                          Yes
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="experience_evacuation" id="experience_evacuation" value="2">
                                        <label class="form-check-label" for="experience_evacuation">
                                          No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <h5>House is</h5>
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-6">
                                    <div class="form-check mb-1">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="1" id="flood_prone" name="flood_prone">
                                            <label class="form-check-label" for="flood_prone">
                                              Flood prone
                                            </label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="1" id="landslide prone" name="landslide prone">
                                            <label class="form-check-label" for="landslide prone">
                                                Landslide prone
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-status" role="tabpanel" aria-labelledby="nav-status-tab">
                            <div class="row form-row mb-3 mt-2 fw-bold">
                                <div class="form-group col-md-6">
                                    <h5>PSA registered</h5>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="psa_registered" id="psa_registered" value="1">
                                        <label class="form-check-label" for="psa_registered">
                                          Yes
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="psa_registered" id="psa_registered" value="2">
                                        <label class="form-check-label" for="psa_registered">
                                          No
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <h5>Experience crime or any form of illegal?</h5>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="crime_victim" id="crime_victim" value="1">
                                        <label class="form-check-label" for="crime_victim">
                                          Yes
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="crime_victim" id="crime_victim" value="2">
                                        <label class="form-check-label" for="crime_victim">
                                          No
                                        </label>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="crime_cause" class="form-label"><span class="text-muted" style="font-size: 12px">If yes, type the cause:</span></label>
                                        <input type="text" class="form-control" name="crime_cause" id="crime_cause">
                                    </div>
                                </div>
                            </div>
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
                    <input hidden name="issued_id" id="issued_id">
                    <input hidden type="text" name="issued_name" id="issued_name">
                    <div class="form-group col-md-12">
                        <label for="cert_type" class="form-label">Certificate Type:</label>
                        <select class="form-select" aria-label="Default select example" name="cert_type" id="cert_type">
                            <option selected>Select option</option>
                            @foreach ($certificate as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
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
            ajax: "{{ route('resident') }}",
            deferRender: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'household_no', name: 'household_no'},
                {data: 'name', name: 'name'},
                {data: 'zone_name', name: 'zone_name', class: 'text-end'},
                {data: 'cp_number', name: 'cp_number', class: 'text-end'},
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
                        $('#residentForm').trigger("reset");
                        $('#addModal').modal('show');
                        $('#savedata').html('Save');
                    },
                }
            ]
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


        // get certificate
        $('body').on('click', '.issueCertificate', function () {
            var id = $(this).data('id');
            $.ajax({
                type:"GET",
                url: "{{ url('barangay/residents/issue-certificate') }}",
                data: { id: id},
                dataType: 'json',
                    success: function(data){
                        $('#certificateModal').modal('show');
                        $('#issued_name').val(data.name);
                        $('#issued_id').val(data.id);

                    }
            });
        });

        // save issued certificate
    
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
                    table.draw();
                    toastr.success('Certificate issued successfully','Success');
                },
                error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                }
            });
        });


        //generate account
          $('body').on('click', '.generateResidentAccount', function () {
            var id = $(this).data('id');
            if (confirm("Generate email and password for this account?") === true) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('resident.account') }}",
                    data:{
                    id:id
                    },
                    success: function (data) {
                    table.draw();
                    toastr.success('Account generated successfully','Success');
                    },
                    error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
                });
            }
        });


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

    // if($('#crime_victim').is(":checked")){
    //     alert('yes is checked');
    // }
    $('#submenu1').addClass('show').removeClass('hide');
</script>

@endsection
