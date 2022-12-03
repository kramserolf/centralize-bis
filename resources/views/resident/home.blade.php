@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center px-2 fw-bold text-secondary mb-3"> Announcements</h3>
<div class="row">
    @foreach ($announcements as $row )
        <div class="col-md-8 col-lg-10 col-sm-4">
            <div class="post-preview">
                <h2 class="post-title fw-bold">{{ $row->title }}</h2>
                <h5 class="post-subtitle">{{ $row->content }}</h5>
                <p style="font-size: 13px" class="post-meta">From Barangay <strong>{{ $row->barangayName }}</strong> on {{ date('M j, Y h:i a', strtotime($row->created_at)) }}</p>
            </div>
            <hr />
        </div>
    @endforeach
</div>
</div>

@include('modal.certificate')
@endsection