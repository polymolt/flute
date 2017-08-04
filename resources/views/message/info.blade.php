@extends('layouts.app')

@section('title', 'Flute')

@section('box-content')
    <div class="content">
        <div class="header">{{ $page_header }}</div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="ui sub header" style="margin-top: .7em">{{ $error }}</p>
            @endforeach
        @endif
    </div>
    <div class="content">
        <p>
            {!! nl2br(e($info)) !!}
        </p>
    </div>
@endsection

@section('box-info', $extra_info)