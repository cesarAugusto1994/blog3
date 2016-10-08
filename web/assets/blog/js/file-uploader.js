/**
 * Created by cesar on 12/09/16.
 */
$(document).ready(function(){

    $('#filer_input').filer({
        showThumbs: true,
        addMore: true,
        limit: 40,
        maxSize: 25,
        extensions: ["jpg", "png", "mp3", "pdf", "doc", "docx", "gif", "enc", "mid", "3gp", "wma", "wav"],
    });

});
