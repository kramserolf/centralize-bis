@extends('layouts.admin-sidebar')
<style>
    .admin-home{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 mb-4 fw-bold text-secondary">  Administrator Dashboard</h4>
<div class="row px-5 mt-3 justify-content-center">
    <div class="col-md-4 p-2 mt-2">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body text-center">
                <div class="row no-gutters">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-secondary fw-bold mb-3">Total Residents</div>
                        <div class="h2 m-3 fw-bold">{{$total_population}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 p-2 mt-2">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body text-center">
                <div class="row no-gutters">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-secondary fw-bold mb-3">Barangay Accounts</div>
                        <div class="h2 m-3 fw-bold">{{$total_accounts}}</div>
                        
                    </div>
                </div>
                {{-- <div class="m-2">
                    <span class="text-success fw-bold">
                        <i class="bi-graph-up" style="font-size: 16px; margin-right: 6px"></i>
                    </span>
                    </span> <span  style="font-size: 12px;">
                        Past 7 days
                    </span>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="col-md-4 p-2 mt-2">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body text-center">
                <div class="row no-gutters">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-secondary fw-bold mb-3">Resident Accounts</div>
                        <div class="h2 m-3 fw-bold">0</div>
                        
                    </div>
                </div>
                {{-- <div class="m-2">
                    <span class="text-success fw-bold">
                        <i class="bi-graph-up" style="font-size: 16px; margin-right: 6px"></i>
                    </span>
                    </span> <span  style="font-size: 12px;">
                        Past 7 days
                    </span>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- <div class="col-md-3 p-2 mt-2">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body text-center">
                <div class="row no-gutters">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-secondary fw-bold mb-3">Total Residents</div>
                        <div class="h2 m-2 fw-bold">{{$page_views}}</div>
                        
                    </div>
                </div>
                <div class="m-2">
                    <span class="text-success fw-bold">
                        <i class="bi-graph-up" style="font-size: 16px; margin-right: 6px"></i>
                    </span>
                    </span> <span  style="font-size: 12px;">
                        Past 30 days
                    </span>
                </div>
            </div>
        </div>
    </div> --}}
</div>
    {{-- <div class="d-flex justify-content-evenly">
        <div class="col-md-4 p-2 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center text-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-3">registered residents</div>
                            <div class="mb-1">
                                <i class="bi-people fs-3 text-success"></i>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_population }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_accounts}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> --}}
@endsection
