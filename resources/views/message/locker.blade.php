@extends('layouts.app')

@section('title', config('app.name'))

@section('box-content')
    <div class="content">
        <div class="header">{{ __('ui.decrypt_message_header') }}</div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="ui sub header" style="margin-top: .7em">{{ $error }}</p>
            @endforeach
        @endif
    </div>
    <div class="content">
        <form class="ui form" action="/{{ $id }}" method="post">
            <div class="field">
                <label>{{ __('ui.password_label') }}</label>
                <input type="password" name="password">
            </div>
            <button class="fluid ui secondary button" type="submit">{{ __('ui.decrypt_button') }}</button>
        </form>
    </div>
@endsection

@section('box-info', __('ui.decrypt_message_info'))