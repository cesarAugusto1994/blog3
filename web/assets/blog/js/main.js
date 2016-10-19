$(function () {
    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });

    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
});

alertify.defaults = {
    // dialogs defaults
    autoReset:true,
    basic:false,
    closable:true,
    closableByDimmer:true,
    frameless:false,
    maintainFocus:true, // <== global default not per instance, applies to all dialogs
    maximizable:true,
    modal:true,
    movable:true,
    moveBounded:false,
    overflow:true,
    padding: true,
    pinnable:true,
    pinned:true,
    preventBodyShift:false, // <== global default not per instance, applies to all dialogs
    resizable:true,
    startMaximized:false,
    transition:'pulse',

    // notifier defaults
    notifier:{
        // auto-dismiss wait time (in seconds)
        delay:5,
        // default position
        position:'bottom-right'
    },

    // language resources
    glossary:{
        // dialogs default title
        title:'Alerta',
        // ok button text
        ok: 'OK',
        // cancel button text
        cancel: 'Cancel'
    },

    // theme settings
    theme:{
        // class name attached to prompt dialog input textbox.
        input:'ajs-input',
        // class name attached to ok button
        ok:'ajs-ok',
        // class name attached to cancel button
        cancel:'ajs-cancel'
    }
};

function block_screen() {
    alertify.message('<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>');
    $('<div id="screenBlock"></div>').appendTo('body');
    $('#screenBlock').css( { opacity: 0, background: '#f6f6f6', width: $(document).width(), height: $(document).height() } );
    $('#screenBlock').addClass('blockDiv');
    $('#screenBlock').animate({opacity: 0.8}, 200);
}

function unblock_screen() {
    $('#screenBlock').animate({opacity: 0}, 200, function() {
        $('#screenBlock').remove();
    });
}