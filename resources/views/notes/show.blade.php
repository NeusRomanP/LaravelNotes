@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <h2 class="center-text">Edit note</h2>

        
        <div class="flex flex__center center-text">
            <div>
                <div class="go-back">
                    <a href="{{ route('notes.index') }}">Back to notes</a>
                </div>
                <form id="myForm" method="POST">
                    @csrf
                    <div>
                        <label for="title">Title</label>
                        <input id="title" type="text" name="title" value="{{ $note->title }}"/>
                    </div>
                                
                    <div>
                        <label for="note">Note</label>
                        <textarea id="content" name="note" id="note" cols="30" rows="10">{{ $note->content }}</textarea>
                    </div>
        
        
                    <div>
                        <label for="users[]">Share with</label>
                        <input type="text" name="user" id="user" autocomplete="off">
                        <div class="users-outer-container">
                            <div id="users-container"></div>
                        </div>
                        <div id="users-to-share-with"></div>
                    </div>
                </form>
        
                <button id="submitEdit">Edit</button>
        
                <div>
                    <p>Created by <b>{{ $creator->name }}</b></p>
                </div>
        
                <div>
                    <p>
                        Shared with:
                        <i>
                            @for ($i = 0; $i < count($sharedWith); $i++)
                                @if ($i < (count($sharedWith)-1))
                                    {{ $sharedWith[$i]->name}}, 
                                @else
                                    {{ $sharedWith[$i]->name}}
                                @endif
                            @endfor
                        </i>
                    </p>
                </div>
        
                <a class="button red white-text" href="{{ route('note.delete', $note->id) }}">Delete note</a>
            </div>
            
        </div>
        
    </div>
</div>

<script src="{{ asset('/js/edit.js') }}"></script>
@endsection