<div class="container">
    <h4 class="text-center px-2 fw-bold text-secondary mb-3"> Announcements</h4>
    <div class="row">
        @foreach ($announcements as $announcement)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $announcement->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $announcement->barangayName }}</h6>
                    <p class="card-text">{{ $announcement->content }}</p>
                    <div class="text-end">
                        <span class="text-muted fw-bold" style="font-size: 13px">{{ $announcement->created_at }}</span>
                    </div>
                    </div>
                </div>
            </div>  
        @endforeach
    </div>
</div> 