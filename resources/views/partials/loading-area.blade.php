<div class="loading-area">
    <div class="loading">
        <img src="{{ GeneralHelper::get_app_logo() }}" alt="Logo">
        <div class="loading-text">
            <div class="title">
                {{ GeneralHelper::get_abb_app_name() }}
            </div>
            <div class="subtitle">
                {{ GeneralHelper::get_app_name() }} <br />
                {{ GeneralHelper::get_unit_name() }}
            </div>
        </div>
        <div class="loading-spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(window).ready(() => {
            setTimeout(() => {
                $(".loading-area").fadeOut();
            }, 500)
        });
    </script>
@endpush
