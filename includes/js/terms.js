(function($) {
    $(document).ready(function(e) {

    $('p.commentable-section, textarea#comment, #submit').on('click', function(){
        $('#cdbr_dialog').remove();

        var widget_title = 'Termos de uso';
        var widget_text = 'Para comentar você precisa concordar com os <a href="'+vars.site_url+'/termos-de-uso">termos de uso</a>.';
        
        $.post(
            vars.ajaxurl, 
            {
                action: 'get_usermeta_confirm_terms'
            },
            function(response) {

                if( response == false){

                    $('<div id="cdbr_dialog"></div>').appendTo( $( "body" ) )
                      .html('<div id="dialog-confirm" title="'+widget_title+'"><p>'+widget_text+'</p></div');

                    $('#dialog-confirm').dialog({
                        resizable: false,
                        draggable: false,
                        modal: true,
                        closeOnEscape: false,
                        buttons: {
                            "Sim, eu concordo": function() {
                               $.post(
                                    vars.ajaxurl, {
                                        action: 'register_confirm_terms'
                                    },
                                    function(response) {
                                        //
                                    });

                                $( this ).dialog( "close" );
                            },
                            "Não, eu não concordo": function() {
                              $( this ).dialog( "close" );
                              return false;
                            }
                        }
                    });        
                }
            });
        });       
    });
})(jQuery);