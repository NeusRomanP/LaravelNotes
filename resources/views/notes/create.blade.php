@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">

        <h2 class="center-text">Create a new note</h2>
        <div class="flex flex__center center-text">
            <div>
                <div class="go-back">
                    <a href="{{ route('notes.index') }}">Back to notes</a>
                </div>
                <form action="{{ route('note') }}" method="post">
                    @csrf
                    <div>
                        <label for="title">Title</label>
                        <input type="text" name="title"/>
                    </div>
                                
                    <div>
                        <label for="note">Note</label>
                        <textarea name="note" id="note" cols="30" rows="10"></textarea>
                    </div>
        
                    <input type="submit" value="Save">          
                </form>
            </div>
        </div>
    </div>
</div>
@endsection