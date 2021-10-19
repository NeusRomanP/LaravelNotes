@extends('layouts.app')

@section('content')
<div class="container flex center-text">
    <div class="home-container">
        <h1>
            {{ __('Share your notes with other users') }}
        </h1>
    
        @if (Auth::user()!==null )
    
            <h2 class="center-text">Go to your <a href="{{ route('notes.index') }}">NOTES</a></h2>
                        
        @else
            <h2 class="-center-text">Log in to create and share your notes</h2>
        @endif
    </div>
    
</div>
@endsection
