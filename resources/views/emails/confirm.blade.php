
@component('mail::message')
    welcome {{$user->name}}


    You changed your e-mail , please verify your new account using the button below :

    @component('mail::button', ['url' => route('verify' , $user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
