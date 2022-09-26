@extends('layouts.admin-sidebar')
<style>
    #home, #homeIcon {
        background-color: gray;
    }
</style>
@section('content')
    <div class="m-4">
        <span class="badge bg-info fs-4">Admin Dashboard</span>
    </div>
    <div class="d-flex justify-content-evenly">
        <div class="col-md-4 p-2 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center text-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-3">registered population</div>
                            <div class="mb-1">
                                <i class="bi-people fs-3 text-success"></i>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">127,586</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-2 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center text-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-3">registered voters</div>
                            <div class="mb-1">
                                <i class="bi-people fs-3 text-success"></i>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">67,048</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 p-2 mt-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center text-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-3">registered accounts</div>
                            <div class="mb-1">
                                <i class="bi-people fs-3 text-success"></i>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">35</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
