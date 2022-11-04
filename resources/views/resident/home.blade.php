@extends('layouts.app')

@section('content')
    @foreach ($announcements as $item)
   
        <div class="d-flex flex-nowrap">
            <div class="sm-4 p-2" style="width: 100%">
                <img src="{{asset('images/announcements/'.$item->image.'')}}" class="img-thumbnail" alt="img-thumbnail">
                <span class="px-3" style="font-size: 10px">{{date('F j, Y, g:i a', strtotime($item->created_at))}}</span>
            </div>
            <div class="mt-3">
                <a href="#" style="text-decoration: none; color:black"><strong>{{$item->title}}</strong><br>
                    <span style="font-size: 12px">{{$item->content}}</span>
                </a>
            </div>
          
      
        </div>
    </div>
        <div class="d-flex justify-content-center mb-2">
            <div class="col-sm-6 p-2">
                
                
            </div>
     
            <div class="p-2">
                
            </div>
        </div>

    @endforeach
@endsection