@extends('layouts.app')

@section('title', config('app.name') . ' ' .'Metrix')

@section('box-content')
    <div class="content">
        <div class="header">{{ __('ui.metrix_header') }}</div>
        <p class="ui sub header" style="margin-top: .7em">{{ __('ui.metrix_refresh_info') }}</p>
    </div>
    <div class="content" style="font-family: 'Courier', mono; text-align: center; padding: 2em 2em 1.7em;">
        @foreach ($passphrase_metrix as $passphrase_grouped)
            @if($loop->last)
         		<p style="margin-bottom: 1.4em;">{{ $passphrase_grouped }}</p>
         		@break
            @endif
            <p>{{ $passphrase_grouped }}</p>
        @endforeach
        <a href="/metrix"><i class="refresh icon"></i>{{ __('ui.metrix_button_refresh') }}</a>
    </div>
@endsection

@section('box-info', __('ui.metrix_info'))