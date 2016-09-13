/**
 * Created by cesar on 12/09/16.
 */
$(document).ready(function(){

    $('#filer_input').filer({
        showThumbs: true,
        addMore: true,
        limit: 20,
        maxSize: 120,
        extensions: ["jpg", "png", "mp3", "pdf", "doc", "docx", "gif"],
    });

});
