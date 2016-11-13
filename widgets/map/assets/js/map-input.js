(function ($) {

    $(function () {
        ymaps.ready(init);
    });

    function init () {
        var point = $('#map-point'),
            map = new ymaps.Map('map', {
                center: [53.54478, 49.34723],
                zoom: 14,
                controls: ['zoomControl']
            });
        if (geoObj && !point.data('id') && !point.data('error')) {
            var objectManager = new ymaps.ObjectManager({
                clusterize: true,
                gridSize: 32
            });
            objectManager.add(geoObj);
            map.geoObjects.add(objectManager);
            map.setBounds( objectManager.getBounds(), { checkZoomRange: true } );
            if (map.getZoom()>18) {
                map.setZoom(14)
            }
        } else {
            setEditObj();
        }
        var pointPreset = $('#map-preset');
        if(pointPreset.val().length < 5) {
            pointPreset.val('islands#darkGreenStretchyIcon');
        }
// TODO: Настроить zoom
        map.events.add('actiontick', function () {
            $('#map-zoom').val(map.action.getCurrentState().zoom);
        });

        function setEditObj() {
            var point = $('#map-point'),
                coor = point.val().split(','),
                title = $("#map-title").val(),
                preset = $("#map-preset").val();
            if ( coor.length == 2 ) {
                var myGeoObject = new ymaps.GeoObject({
                    geometry: {
                        type: "Point",
                        coordinates: coor
                    },
                    properties: {
                        iconContent: title,
                        hintContent: 'Метку можно перетасскивать'
                    }
                }, {
                    preset: preset,
                    draggable: true
                });
                var editObj = map.geoObjects.add(myGeoObject);
                map.setCenter(coor, 14);
                editObj.events.add('drag', function (e) {
                    point.val(getCoords(e.get('target').geometry.getCoordinates()));
                });
                return editObj;
            } else {
                return false;
            }

        }

        function setNewObj() {
                var newGeoObject = new ymaps.GeoObject({
                geometry: {
                    type: "Point",
                    coordinates: getCoords(map.getCenter())
                },
                properties: {
                    iconContent: 'Новая метка',
                    hintContent: 'Метку можно перетасскивать'
                }
            }, {
                preset: document.getElementById("map-preset").value,
                draggable: true
            });
            document.getElementById("map-point").value = getCoords(map.getCenter());
            document.getElementById("map-title").value = 'Новая метка';
            return map.geoObjects.add(newGeoObject);
        }

        function getCoords(Coords) {
            var lant = Coords[0].toFixed(5), long = Coords[1].toFixed(5);
                Coords = [lant,long];
            return Coords;
        }

        $('#collapseMap').on('show.bs.collapse', function () {
            $('#collapseMap').attr('id','DisableButton');
            var input = document.getElementById("map-point");
            setNewObj().events.add('drag', function (e) {
                input.value = getCoords(e.get('target').geometry.getCoordinates());
            });
        });

    }
})(jQuery);