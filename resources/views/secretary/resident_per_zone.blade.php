@extends('layouts.secretary-sidebar')
<style>
    .sidebar-brgy{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary">Residents per Zone</h4>
<div class="m-2">
    <div class="d-flex justify-content-between">
        <div class="col-md-2">
            <select class="form-select form-select-sm fw-bold" aria-label="Default select example" name="zone" id="select_zone">
                <option selected>Select Zone</option>
                @foreach ($filter_zone as $zone )
                    <option value="{{ $zone->id }}">{{ $zone->zone }}</option>
                @endforeach
              </select>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm fw-bold" name="search" id="search" placeholder="Search here">
        </div>
    </div>
</div>
    <div class="m-2 text-center">
        <span hidden id="rowCount"><strong></strong></span>
    </div>
    <table class="table table-bordered table-sm data-table nowrap w-100">
        <thead>
            <tr class="table-primary text-uppercase">
                <td class="text-center" style="width: 10%;" id="household">Household No.</td>
                <td class="text-center" >Name</td>
                <td class="text-center">Zone</td>
                <td class="text-center" >Mobile No.</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="overlay"></div>
<script>
    
    $(document).ready(function(){

        // $('#barangay').trigger('click');

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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


        $('#select_zone').on('change', function(){
            var zone = $('#select_zone').val();
            $.ajax({
                type: "GET",
                url: "{{ url('barangay/resident/filter-by-zone') }}",
                data: {'zone':zone},
                    success: function(data){
                        var result = $('tbody').html(data);
                        var count = $('.data-table tbody tr').length;
                        $('#rowCount').html(count + ' of residents found');
                        $('#rowCount').attr('hidden', false);
                        toastr.success('Filtered zone successfully','Success');
                    },
                    error: function(data){
                        toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
            });
        });

        $('#search').on('keyup', function(){
            var search = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ url('barangay/resident/zone/search') }}",
                data: {'search':search},
                    success: function(data){
                        var result = $('tbody').html(data);
                        var count = $('.data-table tbody tr').length;
                        $('#rowCount').html(count + ' of residents found');
                        $('#rowCount').attr('hidden', false);
                    },
                    error: function(data){
                        toastr.error(data['responseJSON']['message'],'Error has occured');
                    }
            })
        })


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

    $(document).on({
        ajaxStart: function(){
            $('body').addClass('loading');
        },
        ajaxStop: function(){
            $('body').removeClass('loading');
        }
    });
</script>

@endsection
