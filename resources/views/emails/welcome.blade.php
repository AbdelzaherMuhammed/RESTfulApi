@component('mail::message')
    welcome {{$user->name}}

    Thank you fro creating an account , please verify your account using this button :

    @component('mail::button', ['url' => route('verify' , $user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

