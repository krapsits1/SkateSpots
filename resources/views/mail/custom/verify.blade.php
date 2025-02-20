@component('mail::message')
# Verify Your Email Address

Hi SkatesSpots User,

Thank you for registering at {{ config('app.name') }}. Please click the button below to verify your email address.

@component('mail::button', ['url' => $url])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required. 

Thanks,<br>
{{ config('app.name') }}

@endcomponent