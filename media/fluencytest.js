jQuery(document).ready(function($) {
    
    $('#get_quote').on('click', function() {
        if ($('input#postcode').val() != "") {
            $.cookie("postcode", $('input#postcode').val());
            $.post( 'ajax/processajax.php', 
                    {
                        'action' : 'storeQuote',
                        'customer_name' : $('input#customer_name').val(),
                        'contract_length' : $('select#contract_length').val(),
                        'site_name' : $('input#site_name').val(),
                        'postcode' : $('input#postcode').val(),
                        'request_type' : 'json'
                    }, 
                    function(response){
                        $.cookie("master_quote", response);
                        $.post(   'ajax/processajax.php', 
                                    {
                                        'action' : 'processQuote',
                                        'postcode' : $.cookie("postcode"),
                                        'master_quote' : $.cookie("master_quote"),
                                        'request_type' : 'json'
                                    }, 
                                    function(response){
                                        var jsonData = $.parseJSON(response);
                                        console.log(jsonData);
                                        if (jsonData.Openreach) {
                                            console.log(jsonData.Openreach);
                                        }
                                        if (jsonData.TalkTalk) {
                                            console.log(jsonData.TalkTalk);
                                        }
                                        
                                        
                                    }
                            );
                    }
                );
        } else {
            alert('A Quote MUST contain a Postcode');
        }
        return false; 
    });
    
});