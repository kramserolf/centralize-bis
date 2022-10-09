@extends('layouts.secretary-sidebar')
<style>
    .sidebar-home{
       color: rgb(180, 179, 179);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary">     Dashboard</h4>
<div class="d-flex justify-content-center">
    <div class="col-md-4 p-2 mt-2">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center text-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-3">total population</div>
                        <div class="mb-1">
                            <i class="bi-people fs-3 text-success"></i>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total}}</div>
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
