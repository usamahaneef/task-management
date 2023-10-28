@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => '...'])
            <img src="{{asset('admin/img/admin-banner-image.png')}}" width="100" alt="Logo"> 
        @endcomponent
    @endslot

    {{-- Body --}}
    @slot('subcopy')
        <h2 style="text-align: center;">{{ $details['title'] }}</h2>
        <p>Hello {{ $details['name'] }},</p>
        
        <p>You are receiving this email because we received a forgot password request for your account.</p>
        <h2 style="text-align: center; font-weight:bold;">Your forgot password OTP</h2>
        <h2 style="text-align: center; color:lightblue;">{{ $details['token'] }}</h2>

        <p>If you did not request a password reset, no further action is required.</p>
    @endslot
@endcomponent

