<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="noindex,nofollow">
    <meta name="googlebot" content="noindex">
    <meta name="og:image" content="{{ GeneralHelper::get_ads() }}" />
    <meta name="og:description"
        content="{{ GeneralHelper::get_app_name() . ' (' . GeneralHelper::get_abb_app_name() . ') - ' . GeneralHelper::get_unit_name() }}" />
    <title>{{ GeneralHelper::get_app_name() . ' | ' . GeneralHelper::get_unit_name() }}</title>
    <link rel="icon" type="image/x-icon" href="{{ GeneralHelper::get_favicon() }}">
    <link href="{{ asset('css/main.min.css') }}" rel="stylesheet" />
    @production
        <link rel="stylesheet" href="{{ asset('css/custom.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @endproduction
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @livewireStyles
    @stack('heads')
</head>

<body class="sb-nav-fixed">
    @include('sweetalert::alert')
    @include('partials/loading-area')

    @include('partials/navbar')

    <div id="layoutSidenav">
        @include('partials/sidebar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid py-0 px-0 py-lg-4 px-lg-4">
                    @yield('container')
                </div>
            </main>
            @include('partials/footer')
        </div>
    </div>

    @include('partials/js')
</body>

</html>
