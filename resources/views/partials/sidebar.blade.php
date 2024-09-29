<div id="layoutSidenav_nav">
    {{-- Sidebar Toggle --}}
    <div class="sidebar-toggle">
        <button class="btn btn-link" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </div>
    <nav class="sb-sidenav accordion sb-sidenav-primary" id="sidenavAccordion">
        <div class="sb-sidenav-user">
            <div class="userdata">
                <div class="avatar">
                    <img src="{{ Auth::user()->avatar ?? asset('avatar_default.png') }}" alt="Avatar">
                </div>
                <div class="information">
                    <div class="fullname">
                        {{ Auth::user()->fullname }}
                    </div>
                    <div class="role">
                        {{ Auth::user()->role_name }}
                    </div>
                    <div class="base">
                        <div class="item">
                            {{ auth()->user()?->district->name ?? '-' }}
                        </div>
                        <div class="item">
                            {{ auth()->user()?->village->name ?? '-' }}
                        </div>
                        <div class="item">
                            {{ auth()->user()?->tps->name ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="button">
                <form action="{{ route('logout') }}" method="post" class="d-inline">
                    @csrf
                    @method('post')
                    <button type="submit" class="btn btn-sm btn-danger" id='logout-button'>
                        <i class="fas fa-sign-out"></i>
                        <span>
                            Keluar
                        </span>
                    </button>
                </form>
            </div>
            <div class="sb-show-user" id="minified-user">
                <i class="fas fa-chevron-up"></i>
            </div>
        </div>
        <div class="sb-sidenav-menu">

            <div class="nav">
                {{-- DASHBOARD --}}
                <a class="nav-link @if (Request::routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Beranda
                </a>
                {{-- END DASHBOARD --}}
                @foreach (SidebarHelper::get() as $sidebar)
                    @if (count($sidebar['items']) > 0 && collect($sidebar['items'])->some(fn($item) => $item['permission'] == true))
                        @if ($sidebar['title'])
                            <span class="nav-link title">
                                {{ $sidebar['title'] }}
                            </span>
                        @endif
                        @foreach ($sidebar['items'] as $item)
                            @if ($item['permission'])
                                <a class="nav-link @if (Route::has($item['route']) && request()->routeIs($item['route'])) active @endif"
                                    href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}">
                                    <div class="sb-nav-link-icon"><i class="{{ $item['icon'] }}"></i></div>
                                    {{ $item['title'] }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </nav>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {
            const sidebarToggle = $("#sidebarToggle");
            const body = $("body");

            const setSidebarToggle = () => {
                if (screen.width <= 991) {
                    if (body.hasClass("sb-sidenav-toggled"))
                        sidebarToggle.html("<i class='fas fa-times'></i>");
                    else sidebarToggle.html("<i class='fas fa-bars'></i>");
                } else {
                    if (body.hasClass("sb-sidenav-toggled"))
                        sidebarToggle.html("<i class='fas fa-bars'></i>");
                    else sidebarToggle.html("<i class='fas fa-times'></i>");
                }
            };

            if (localStorage.getItem("sb|sidebar-toggle") === "true") {
                body.toggleClass("sb-sidenav-toggled");
            }

            const setLocalStorage = () => {
                body.toggleClass("sb-sidenav-toggled");
                setSidebarToggle();

                localStorage.setItem(
                    "sb|sidebar-toggle",
                    body.hasClass("sb-sidenav-toggled")
                );
            }

            sidebarToggle.on("click", (event) => {
                event.preventDefault();

                setLocalStorage()
            });

            let deg = 180
            let rotate = 0;

            $('#minified-user').click(() => {
                minified()
            })

            const minified = () => {
                $('.sb-sidenav-user').toggleClass('minified')

                rotate += deg
                $('.sb-show-user svg').css({
                    'transform': `rotate(${rotate}deg)`
                });

                if ($('.sb-sidenav-user').hasClass('minified'))
                    localStorage.setItem('minified-avatar', true)
                else
                    localStorage.removeItem('minified-avatar')
            }

            const check_minified = () => {
                const get_item = (localStorage.getItem('minified-avatar') === 'true')
                setSidebarToggle();

                if (get_item)
                    minified()
            }

            check_minified()

            if (screen.width <= 991)
                $(".sb-sidenav-toggled #layoutSidenav #layoutSidenav_content").before().on('click', () => {
                    if (body.hasClass('sb-sidenav-toggled'))
                        setLocalStorage()
                })

            $('#logout-button').on('click', (e) => {
                e.preventDefault();

                Swal.fire({
                    title: "Perhatian!",
                    text: "Apakah kamu yakin akan keluar?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.clear()
                        $('.loading-area').fadeIn()
                        $(e.target).closest("form").submit(); // Post the surrounding form
                    }
                });
            })
        })
    </script>
@endpush
