<!doctype html>
<html lang="{{ config('app.locale') }}" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>{{ config('app.name') }}</title>

        <meta name="description" content="{{ config('app.name') }}">
        <meta name="author" content="MIS">
        <meta name="robots" content="noindex, nofollow">

        {{-- <meta property="og:url"  content="@yield('content_url')" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="@yield('pageTitle')" />
		<meta property="og:description" content="@yield('pageTitle')" />
		
		<link rel="image_src" type="image/jpg" href="@yield('pageImage')" />
		<meta property="og:image" content="@yield('pageImage')">
		<meta property="og:image:secure_url" content="@yield('pageImage')">
		<meta property="og:image:width" content="@yield('image_width')">
		<meta property="og:image:height" content="@yield('image_height')">
		<meta name="twitter:image" content="@yield('pageImage')"> --}}

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('logo-sis.ico') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('logo-sis.ico') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-sis.ico') }}">

        <!-- Fonts and Styles -->
        @yield('css_before')
        <link rel="stylesheet" href="{{ asset('fonts/font-face-muli.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ mix('/css/codebase.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('/css/custom.sis.cloud-services.css') }}">
       
        <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/corporate.css') }}"> -->
        @yield('css_after')

        <!-- Scripts -->
        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
    </head>
    <body>
        <!-- Page Container -->
        <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-inverse'                           Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Classic Header style if no class is added
            'page-header-modern'                        Modern Header style
            'page-header-inverse'                       Dark themed Header (works only with classic Header style)
            'page-header-glass'                         Light themed Header with transparency by default
                                                        (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
            'page-header-glass page-header-inverse'     Dark themed Header with transparency by default
                                                        (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed enable-cookies " >
            <!-- Side Overlay-->
            @include('partials._side-right')
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            @include('partials._sidebar-left')
            <!-- END Sidebar -->

            <!-- Header -->
            @include('partials._header')
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                @yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            @include('partials._footer')
            <!-- END Footer -->

            <!-- page loader -->
                <div id="page-loader" class="show"></div>
            <!-- END page loader -->
        </div>
        <!-- END Page Container -->
        @yield('js_before')
        <!-- Codebase Core JS -->
        <script src="{{ mix('js/codebase.app.js') }}"></script>

        <!-- Laravel Scaffolding JS -->
        <script src="{{ mix('js/laravel.app.js') }}"></script>

        <!-- bootstrap notify JS -->
        <script src="{{ asset('/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

        <!-- custom JS -->
        <script src="{{ asset('/js/custom.sis.js') }}"></script>

        <!-- bootstrap sweetalert2 -->
        <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <link rel="stylesheet" id="css-main" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">

        @yield('js_after')
        @yield('js_after_noit')
    </body>
</html>
