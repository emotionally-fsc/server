<!--
    The main layout for the entire system. It imports all the dependencies and defines all the common sections.
-->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:title" content="Emotionally" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ asset('/images/og-image.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('/images/favicons/16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicons/32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicons/64x64.png') }}" sizes="64x64">
    <link rel="stylesheet" href="{{ asset(mix('/css/app.css')) }}">
    @yield('head', '')

    <title>@yield('title') | Emotionally</title>
</head>
<body @yield('body-attr', '')>
    <nav aria-labelledby="skip-navigation-link">
        <a id="skip-navigation-link" class="skip-navigation" href="#main">Skip to main content</a>
    </nav>
    @yield('body')

    <footer class="el-8dp text-light @yield('footer-class', '')">
        @section('footer')
            <div class="copyright text-white-50 py-2">
                <div class="container-fluid px-3">
                    <p class="d-inline-block mb-0 mt-md-1">
                        Copyright &copy; 2019-{{date('Y')}},
                        <a href="https://F-S-C.github.io/" rel="noopener noreferrer" target="_blank">FSC</a>.
                        @lang('metadata.copyright')
                    </p>
                    <div class="float-right">
                        <span>@lang('accessibility.font_size')</span>
                        <button id="decrease-font-size" class="font-size-button btn btn-md-text">
                            <span class="sr-only">@lang('accessibility.decrease_font_size')</span>
                            <span class="fas fa-minus" aria-hidden="true"
                                  title="@lang('accessibility.decrease_font_size')"></span>
                        </button>
                        <span aria-label="@lang('accessibility.current_font_size')" id="current-font-size">M</span>
                        <button id="increase-font-size" class="font-size-button btn btn-md-text">
                            <span class="sr-only">@lang('accessibility.increase_font_size')</span>
                            <span class="fas fa-plus" aria-hidden="true"
                                  title="@lang('accessibility.increase_font_size')"></span>
                        </button>
                    </div>
{{--                    <img src="{{asset('/fsc_logo_text.png')}}" width="140" alt="Five Students of Computer Science"--}}
{{--                         class="float-md-right d-md-inline-block mr-md-3 d-none">--}}
{{--                    <img src="{{asset('/fsc_logo.svg')}}" width="35" alt="Five Students of Computer Science"--}}
{{--                         class="float-sm-right float-none d-md-none d-sm-inline-block d-none">--}}
                </div>
            </div>
        @show
    </footer>

    <script src="{{asset(mix('/js/app.js'))}}" type="text/javascript"></script>

    <script>
        (function () {
            const DEFAULT_FONT_SIZE = 2;
            let fontSizes = ['XS', 'S', 'M', 'L', 'XL'];
            let currentFontSize = window.localStorage.getItem('font-size') || DEFAULT_FONT_SIZE;
            let decreaseFontSizeButton = $('#decrease-font-size');
            let increaseFontSizeButton = $('#increase-font-size');
            let currentFontSizeIndicator = $('#current-font-size');
            let documentRoot = $('html');

            function getFontSizeClassName(fontSize) {
                return 'font-size-' + fontSizes[fontSize].toLowerCase()
            }

            function limitCurrentFontSize() {
                if (currentFontSize <= 0) {
                    currentFontSize = 0;
                    decreaseFontSizeButton.attr('disabled', true);
                } else if (currentFontSize >= fontSizes.length - 1) {
                    currentFontSize = fontSizes.length - 1;
                    increaseFontSizeButton.attr('disabled', true);
                }
            }

            function resizeFont(previousFontSize = null) {
                currentFontSizeIndicator.text(fontSizes[currentFontSize]);
                if (previousFontSize !== null) documentRoot.removeClass(getFontSizeClassName(previousFontSize));
                documentRoot.addClass(getFontSizeClassName(currentFontSize));

                window.localStorage.setItem('font-size', currentFontSize);
            }


            resizeFont();
            limitCurrentFontSize();

            decreaseFontSizeButton.click(function () {
                currentFontSize--;
                limitCurrentFontSize();
                increaseFontSizeButton.attr('disabled', false);
                resizeFont(currentFontSize + 1);
            });
            increaseFontSizeButton.click(function () {
                currentFontSize++;
                limitCurrentFontSize();
                decreaseFontSizeButton.attr('disabled', false);
                resizeFont(currentFontSize - 1);
            });
        })();
    </script>

    @yield('scripts', '')
</body>
</html>
