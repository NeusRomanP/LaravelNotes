@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">
        <h2 class="center-text">My notes</h2>

        <div class="flex notes-container">
            @foreach ($notes as $note)
                <div class="note-container">
                    <a href="{{ route('show', $note->id) }}">
                        <h2>{{ $note->title}}</h2>
                    </a>
                    <p>{{ $note->content }}</p>
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex flex__center">
        <a class="button black white-text" href="{{ route('note.create') }}">Create note</a>
    </div>
</div>
@endsection