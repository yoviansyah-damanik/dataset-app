<footer>
    <div class="container-fluid px-4 py-2">
        <div class="small text-center text-md-start d-block d-md-flex justify-content-between align-items-end">
            <div>
                {{ GeneralHelper::get_unit_name() }} <br />
            </div>
            <div>
                {{ GeneralHelper::get_app_name() }} ({{ GeneralHelper::get_abb_app_name() }}).
                Versi {{ GeneralHelper::get_version() }}.
            </div>
        </div>
    </div>
</footer>
