(function ($) {

    $(function () {
        ymaps.ready(init);
    });

    function init () {
        var map = new ymaps.Map('map', {
                center: [53.544781, 49.347234],
                zoom: 16,
                controls: ['zoomControl']
            }),
            objectManager = new ymaps.ObjectManager({
                clusterize: true,
                gridSize: 32
            });
        if (geoObj) {
            objectManager.add(geoObj);
            map.geoObjects.add(objectManager);
            map.setBounds( objectManager.getBounds(), { checkZoomRange: true } );
            if (map.getZoom()>18) {
                map.setZoom(14)
            }
        }
    }
})(jQuery);