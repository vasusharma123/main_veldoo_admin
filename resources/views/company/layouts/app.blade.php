<!DOCTYPE html>
<html>
    <head>
        <title>{{ env('APP_NAME') }} {{ isset($page_title)?' - '.$page_title:'' }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <!-- Select Text CSS-->
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <!-- Swiper Slider -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
        <!-- Custom CSS -->
        <link href="{{ asset('new-design-company/assets/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
    </head>
    <body>
        <style>
            .alert-success {
                --bs-alert-color: #0f5132 !important;
                --bs-alert-bg: #fc4c02 !important;
                --bs-alert-border-color: #fc4c02 !important;
                color: white !important;
                max-width: 600px !important;
                margin-top: 30px !important;
                margin-bottom: 0px !important;
            }
            .active>.page-link, .page-link.active {
                z-index: 3;
                color: white !important;
                background-color: #fc4c02 !important;
                border-color: #fc4c02 !important;
            }
        </style>
        @include('company.elements.header')
        <div class="main_content">
            <div class="dashbaord_bodycontent">
                @yield('content')
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://dunggramer.github.io/disable-devtool/disable-devtool.min.js" defer></script>
        <!-- /Scripts -->
        <!-- Select text js -->
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <!-- Swiper Js -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        <!-- Calendar -->
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.8/index.global.min.js'></script>
        <!-- Custom Js -->
        <script src="{{ asset('new-design-company/assets/js/main.js') }}" type="application/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
        <script>
            //Swiper Slider Car
            var swiper = new Swiper(".carSwiper", {
                slidesPerView: 3,
                spaceBetween: 30,
                breakpoints: {
                    190: {
                        slidesPerView:2.5,
                        spaceBetween: 10
                    },
                    480: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    },
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 40
                    }
                }
            });
            //Select Text Js
            var settings = {
                plugins: ['remove_button'],
                create: true,
                onItemAdd:function(){
                    this.setTextboxValue('');
                    this.refreshOptions();
                },
                render:{
                    option:function(data,escape){
                        return '<div class="d-flex"><span>' + escape(data.value) + '</span><span class="ms-auto text-muted">' + escape(data.date) + '</span></div>';
                    },
                    item:function(data,escape){
                        return '<div>' + escape(data.value) + '</div>';
                    }
                }
            };
            if ($('#tom-select-it').length > 0) {
                new TomSelect('#tom-select-it',settings);
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if ($('#calendar').length > 0)
                {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        themeSystem: 'bootstrap5',
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            start: 'prev,today,next title', // will normally be on the left. if RTL, will be on the right
                            center: '',
                            end: '' // will normally be on the right. if RTL, will be on the left
                        }
                    });
                    calendar.render();
                }
            });
            document.addEventListener('DOMContentLoaded', function() {
                if ($('#calendar').length > 0)
                {
                    var calendarEl = document.getElementById('calendar2');
                    var calendar = new FullCalendar.Calendar(calendarEl, {

                        themeSystem: 'bootstrap5',
                        initialView: 'timeGridWeek',
                        headerToolbar: {
                            start: 'prev,today,next title', // will normally be on the left. if RTL, will be on the right
                            center: '',
                            end: '' // will normally be on the right. if RTL, will be on the left
                        }
                    });
                    calendar.render();
                }
            });
        </script>
        @yield('footer_scripts')
    </body>
</html>
