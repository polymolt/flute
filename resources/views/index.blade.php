@extends('layouts.app')

@section('title', config('app.name'))

@section('box-content')
    <div class="content">
        <div class="header">{{ __('ui.new_message_header') }}</div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="ui sub header" style="margin-top: .7em">{{ $error }}</p>
            @endforeach
        @endif
    </div>
    <div class="content">
        <form class="ui form"action="/" method="post">
            <div class="field">
                <label>{{ __('ui.message_label') }}</label>
                <textarea rows="5" name="message" required></textarea>
            </div>
            <div class="field">
                <label>{{ __('ui.password_label') }}</label>
                <input type="password" name="password" required>
            </div>
            <button class="fluid ui secondary button" type="submit">{{ __('ui.encrypt_button') }}</button>
        </form>
    </div>
@endsection

@section('box-info')
    {{ __('ui.new_message_info') }}
    <a class="right floated" href="/metrix" style="color: black;"><i class="random icon"></i>{{__('ui.metrix_header') }}</a>
@endsection