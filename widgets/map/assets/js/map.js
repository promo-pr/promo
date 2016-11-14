(function ($) {

    $(function () {
        ymaps.ready(init);
    });

    function init () {
        var map = new ymaps.Map('map', {
                center: [53.544781, 49.347234],
                zoom: zoom,
                controls: ['zoomControl']
            }),
            objectManager = new ymaps.ObjectManager({
                clusterize: true,
                gridSize: 32
            });
        if (geoObj) {
            objectManager.add(geoObj);
            map.geoObjects.add(objectManager);
            if ( geoObj.features.length > 1 ) {
                map.setBounds( objectManager.getBounds(), { checkZoomRange: true } );
            }
        }
    }
})(jQuery);