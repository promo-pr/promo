(function ($) {

    $(function() {

        $('body').removeClass('no_js').addClass('js');

        $('#FrontSlider').slick({
            dots: true,
            lazyLoad: 'progressive',
            infinite: false,
            centerMode: true,
            variableWidth: true,
            prevArrow: '<i class="slick-prev material-icons">keyboard_arrow_left</i>',
            nextArrow: '<i class="slick-next material-icons">keyboard_arrow_right</i>',
            customPaging: function(slider, i) {
                return $('<i class="material-icons">radio_button_unchecked</i>');
            }
        });

        $('.map-popup').on('click', function (e) {
            e.preventDefault();
            var $body = $('body'),
                styles = {
                    position : 'fixed',
                    left: '0',
                    right: '0',
                    top: '0',
                    bottom: '0',
                    'z-index': '9999'
                },
                $close = $('<i class="material-icons">clear</i>'),
                $popMap = $("<div id='PopMap'></div>").css(styles).prepend($close);
            $body.prepend($popMap).css('overflow','hidden');
            $close.click(function () {
                $popMap.remove();
                $body.removeAttr('style');
            });

            if ($(this).hasClass('map-init')) {
                mapInit();
            } else {
                var url = '//api-maps.yandex.ru/2.1/?lang=ru_RU';
                $.getScript( url, function() {
                    ymaps.ready(
                        function () {
                            mapInit();
                        }
                    );
                });
                $(this).addClass('map-init');
            }

        });


    });

    // Magnific Popup setting Default
    $.extend(true, $.magnificPopup.defaults, {
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below
        closeBtnInside: false,
        zoom: {
            enabled: true, // By default it's false, so don't forget to enable it
            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function
            opener: function (openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        },
        tClose: 'Закрыть (Esc)', // Alt text on close button
        tLoading: 'Загрузка...', // Text that is displayed during loading. Can contain %curr% and %total% keys
        gallery: {
            tPrev: 'Назад', // Alt text on left arrow
            tNext: 'Вперед', // Alt text on right arrow
            tCounter: '%curr% из %total%' // Markup for "1 of 7" counter
        },
        image: {
            tError: '<a href="%url%">Изображение</a> не найдено.' // Error message when image could not be loaded
        },
        ajax: {
            tError: '<a href="%url%">Содержимое</a> не найдено.' // Error message when ajax request failed
        }
    });

    $('.image-popup').magnificPopup({   // One Image popup
        type: 'image'
    });

    $('.image-gallery').each(function() {   //Gallery
        $(this).magnificPopup({
            delegate: '.image-item', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled:true,
                preload: [1,1]
            }
        });
    });

    $('.iframe-popup').magnificPopup({   //Iframe
        type: 'iframe'
    });

    $('.ajax-popup').magnificPopup({    //Ajax
        type: 'ajax'
    });

    //Ajax-form-widget
    $(document).on('ready ajaxComplete', function () {
        $('.ajax-form').on( 'submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = $(this).serialize();
            $(this).find('button:submit')
                .html('<i class="material-icons refresh-animate">cached</i></span>&nbsp;Подождите...')
                .addClass('disabled');
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: formData,
                success: function (data) {
                    $form.replaceWith($(data).children());
                },
                error: function () {
                    alert('Что-то пошло не так. Попробуйте позже.');
                }
            });
        });
        $('.has-error').children(':input').on('change', function (e) {
            $(e.target).parent().removeClass('has-error');
            $(e.target).siblings('.help-block-error').remove();
        });
    });

    function mapInit() {
        var map = new ymaps.Map('PopMap', {
                center: [53.544781, 49.347234],
                zoom: 16,
                controls: ['zoomControl']
            }),
            objectManager = new ymaps.ObjectManager({
                clusterize: true,
                gridSize: 32
            });

        $.ajax({
            url:'/ajax/map',
            type:'POST',
            success: function(data) {
                if (data != 'false') {
                    objectManager.add(data);
                    map.geoObjects.add(objectManager);
                    map.setBounds( objectManager.getBounds(), { checkZoomRange: true } );
                    if (map.getZoom()>18) {
                        map.setZoom(14)
                    }
                }
            }
        });

    }

})(jQuery);