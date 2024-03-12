/**
 * Post
 */
NextPost.Post = function()
{   
    var $page = $("#profile");
    var $form = $page.find("form");
    var $preview = $page.find(".post-preview");
    var filemanager = window.filemanager;
    var $mini_preview = $form.find(".mini-preview");

    var $caption = false; // $ ref. to emojioneare editor
    var $caption_preview = $preview.find(".preview-caption");
    var $caption_preview_placeholder = $preview.find(".preview-caption-placeholder");

    var $img_template = $("<div class='img'></div>");
    var $video_template = $("<video src='#' playsinline autoplay muted loop></video>");

    // Files retrieved in file manager
    filemanager.setOption("onFileAdd", function($file) {
        // Make files draggable in filemanager
        $file.draggable({
            addClasses: false,
            connectToSortable: $mini_preview.find(".items"),
            containment: "document",
            revert: "invalid",
            revertDuration: 200,
            distance: 10,
            appendTo: $mini_preview.find(".items"),
            cursor: "-webkit-grabbing",
            cursorAt: { 
                left: 35,
                top: 35
            },

            
            zIndex: 1000,
            helper: function() {
                var $item = $file.clone();
                var file = $file.data("file");

                $item.removeClass('ofm-file ui-draggable-handle');
                $item.addClass("item");

                $item.find(".ofm-file-ext, .ofm-file-toggle, .ofm-context-menu-wrapper, .ofm-file-icon").remove();

                $item.find(".ofm-file-preview").find("video").appendTo($item.find(">div"));
                $item.find(".ofm-file-preview").removeClass('ofm-file-preview').addClass('img');

                var $c = $item.clone();
                $c.appendTo($mini_preview);

                $item.width($c.outerWidth());
                $c.remove();

                return $item;
            },

            start: function(event, ui) {
                $mini_preview.addClass("droppable");
                $mini_preview.find(".drophere span").toggleClass("none");
                
                $mini_preview.find(".items").sortable("disable");
            },

            stop: function(event, ui) {
                if ($mini_preview.find(".item").length > 1) {
                    $mini_preview.removeClass("droppable");
                }
                $mini_preview.find(".drophere span").toggleClass("none");

                $mini_preview.find(".items").sortable("enable");
            }
        });
    });

    
    // On file select
    filemanager.setOption("onFileSelect", function($file, selected_files) {
        if (filemanager.isDeleteMode()) {
            return false;
        }

        var file = $file.data("file");

        if ($mini_preview.find(".item[data-id='"+file.id+"']").length == 0) {
            __addItemToMiniPreview(file);
        }

        //$file.draggable("disable");
    });
    


    // Upload and select files immediately if dragged file is dropped 
    // to the selected media dropzone ($mini_priview)
    $mini_preview.find(".drophere").on('drop', function(e) {
        filemanager.upload(e.originalEvent.dataTransfer.files, true);
    });

    // If it's mobile device, select uploaded file immediently
    filemanager.setOption("onUpload", function($file) {
        if ($(window).width() <= 600) {
            filemanager.selectFile($file);
            $(".mobile-uploader .result").stop().fadeOut();
        }
    });

    filemanager.setOption("onBeforeUpload", function() {
        if ($(window).width() <= 600) {
            $(".mobile-uploader .result").html(__("Uploading...")).stop().fadeIn();
        }
    });

    filemanager.setOption("onNotificationAdd", function(msg) {
        if ($(window).width() <= 600) {
            $(".mobile-uploader .result").html(msg).stop().fadeIn();
        }
    });

    filemanager.setOption("onNotificationHide", function() {
        $(".mobile-uploader .result").stop().fadeOut();
    });


    // On file unselect
    filemanager.setOption("onFileUnselect", function($file, selected_files) {
        if (filemanager.isDeleteMode()) {
            return false;
        }

        var file = $file.data("file");

        $mini_preview.find(".item").each(function() {
            if ($(this).data("file").id == file.id) {
                $(this).find(".js-close").trigger("click");
                return false;
            }
        });

        //$file.draggable("enable");
    });

  
}