(function( $ ) {



    $.fn.widgetFileInput = function() {

        var $preview = $(this).siblings('.preview');

        $preview.on('click', '.upload-delete', function() {
            var $thumb = $(this).closest('.thumbnail');
            $.post( $(this).data('href'), function( data ) {
                if ( data ) {
                    $thumb.remove();
                }
            });
        });

        $(this).on('change', function () {
            $preview.find('div.thumbnail:not([data-fid])').remove();
            $.each(this.files, function( index, file ) {
                readFile(file, function(e) {
                    var src = e.target.result;
                    $preview.append("<div class='upload thumbnail' style='background-image: url(" + src + ")'></div>");
                });
            });
        });

        function readFile(file, onLoadCallback){
            if (window.FileReader) {
                var reader = new FileReader();
                reader.onload = onLoadCallback;
                reader.readAsDataURL(file);
            } else {
                alert('The File APIs are not fully supported in this browser.');
            }
        }

    };

})(jQuery);