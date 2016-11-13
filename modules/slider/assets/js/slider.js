(function ($) {

    $(function() {

        redactorInit($('.slider-item-body'));

        var $dynamicForm = $('#dynamic-form');

        sortable($dynamicForm, {   // https://github.com/voidberg/html5sortable
            forcePlaceholderSize: true
        });
        sortable($dynamicForm)[0].addEventListener('sortupdate', function() {
            redactorDestroy();
            indexItem();
        });

        $dynamicForm.on('change', '.slider-item-file', function() {
            var file = this.files[0],
                $preview = $(this).closest('.field-slider-item-file').find('.file-preview');

            if (file) {
                readFile(file, function(e) {
                    var result = e.target.result,
                        typ = file.type;
                    typ = typ.split('/')[0];
                    if( typ !== 'image' ) result = '/static/icon/file.png';
                    $preview.css({
                        'background-image': 'url('+result+')',
                        'border': '1px solid #ccc'
                    });
                });
            } else {
                $preview.removeAttr('style');
            }

            function readFile(file, onLoadCallback){
                if (window.FileReader) {
                    var reader = new FileReader();
                    reader.onload = onLoadCallback;
                    reader.readAsDataURL(file);
                } else {
                    alert('The File APIs are not fully supported in this browser.');
                }
            }
        });

        $('.remove-item').click(function () {
            var $item = $(this).closest('.dynamic-form-item'),
                id = $item.find('.slider-item-id').val();
                if (id > 0) {
                    if (confirm('Удалить безвозвратно?')) {
                        $.post("/admin/sliders/" + id + "/slider-item-delete", function (data) {
                            if (data) {
                                $item.remove();
                            }
                        });
                    }
                } else {
                    $item.remove();
                }
                redactorDestroy();
                indexItem();
        });

        $('.add-item').click(function () {
            redactorDestroy();
            var $itemActive = $(this).closest('.dynamic-form-item'),
                $copyItem = $itemActive.clone(true);

            $copyItem.find('.slider-item-body').val('');
            $copyItem.find('input').val('').trigger('change');
            $copyItem.find('.file-preview').removeAttr('style').trigger('change');
            $itemActive.after($copyItem);
            $(this).next().removeClass('hidden');
            indexItem();
        });

        function indexItem() {
            $dynamicForm.find('.dynamic-form-item').each( function (i) {
                $(this).find('.slider-item-id').attr('name', 'SliderItem[' + i + '][id]');
                $(this).find('.slider-item-title').attr('name', 'SliderItem[' + i + '][title]');
                $(this).find('.slider-item-file').attr({'id': 'slide-' + i, 'name': 'slide-' + i});
                var $redactorArea = $(this).find('.slider-item-body');
                $redactorArea.attr({'id': 'redactor-' + i, 'name': 'SliderItem[' + i + '][body]'});
                redactorInit($redactorArea);
            });
            sortable('#dynamic-form');
        }

        function redactorInit($redactorArea) {

            $redactorArea.redactor({
                lang:'ru',
                'minHeight': 160,
                'maxHeight': 160,
                toolbarFixed: false,
                formatting:['blockquote', 'h2', 'h3', 'h4', 'h5']
            }).addClass('redactor-init');
        }
        function redactorDestroy() {
            $dynamicForm.find('.redactor-init').each(function () {
                $(this).redactor('core.destroy');
            });
        }

    });



})(jQuery);
