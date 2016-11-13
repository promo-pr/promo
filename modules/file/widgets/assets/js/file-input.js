(function( $ ) {



    $.fn.widgetFileInput = function() {

        var $preview = $(this).siblings('.preview');

        $preview.on('click', '.upload-crop', function() {

            var $img = $("<img>"),
                $btn = $("<i class='material-icons'>crop_original</i>"),
                $cropWrap = $("<div class='cropper-full'></div>"),
                $imgUpdate = $(this).closest('.upload.thumbnail'),
                fid = $(this).data('fid'),
                src = $(this).data('href'); //Equivalent: $(document.createElement('img'))
            $img.attr('src', src);
            $cropWrap.appendTo($preview);
            $btn.appendTo($cropWrap);
            $img.appendTo($cropWrap);
            $img.cropper();
            $btn.click(function () {
                $img.cropper('getCroppedCanvas').toBlob(function (blob) {
                    var formData = new FormData();
                    formData.append('Crop', blob);
                        $.ajax('/admin/upload/crop?fid=' + fid, {
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function () {
                                $img.cropper('destroy');
                                $cropWrap.remove();
                                var d = new Date();
                                $imgUpdate.css('background-image','url('+src+'?t='+d.getTime()+')');
                                console.log(src);
                            },
                            error: function () {
                                console.log('Upload error');
                            }
                        });
                });
            });
        });

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