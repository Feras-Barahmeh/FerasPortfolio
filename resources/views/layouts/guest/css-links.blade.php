<link rel="stylesheet" href="{{ asset('guest/css/all.min.css') }}">
@stack('style')

@if(App::getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('guest/css/ar/main.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('guest/css/en/main.css') }}">

@endif
