<nav class="sb-topnav navbar navbar-expand navbar-dark">
    {{-- Navbar Brand --}}
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img src="{{ GeneralHelper::get_app_logo() }}" alt="Logo">
    </a>
    <div class="navbar-title">
        <div class="title">
            {{ GeneralHelper::get_abb_app_name() }}
        </div>
        <div class="subtitle">
            {{ GeneralHelper::get_app_name() }} <br />
        </div>
    </div>
    <p id="jam"></p>
</nav>

@push('scripts')
    <script src="{{ asset('js/jqClock.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#jam").clock({
                "format": "24",
                "dateFormat": "l, d F Y",
                "langSet": "id"
            });
        });
    </script>
@endpush
