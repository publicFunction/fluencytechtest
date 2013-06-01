jQuery(document).ready(function($) {
    
    $('#get_quote').on('click', function() {
        if ($('input#postcode').val() != "") {
            $.cookie("postcode", $('input#postcode').val());
            $.cookie("contract", $('select#contract_length').val());
            $.cookie("site_name", $('input#site_name').val());
            $.post( 'ajax/processajax.php', 
                    {
                        'action' : 'storeUser',
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
                                            for (i = 0; i < jsonData.Openreach.Options.length; i++) {
                                                $.post( 'ajax/processajax.php', 
                                                        {
                                                            'action' : 'createQuote',
                                                            'ethernet_quote_id' : $.cookie("master_quote"),
                                                            'site_name' : $.cookie("site_name"),
                                                            'postcode' : $.cookie("postcode"),
                                                            'bandwidth' : '',
                                                            'bearer' : '',
                                                            'carrier' : 'Openreach',
                                                            'buy_price_install' : '',
                                                            'buy_price_rental' : '',
                                                            'wholesale_price_install' : '',
                                                            'wholesale_price_rental' : '',
                                                            'rrp_price_install' : '',
                                                            'rrp_price_rental' : '',
                                                        }, 
                                                        function() {
                                                            
                                                        }
                                                    );
                                                console.log(jsonData.Openreach.Options[i]);
                                            }
                                            
                                        }
                                        if (jsonData.TalkTalk) {
                                            for (i = 0; i < jsonData.TalkTalk.Options.length; i++) {
                                                $.post( 'ajax/processajax.php', 
                                                        {
                                                            'action' : 'createQuote',
                                                            'ethernet_quote_id' : $.cookie("master_quote"),
                                                            'site_name' : $.cookie("site_name"),
                                                            'postcode' : $.cookie("postcode"),
                                                            'bandwidth' : '',
                                                            'bearer' : '',
                                                            'carrier' : 'TalkTalk',
                                                            'buy_price_install' : '',
                                                            'buy_price_rental' : '',
                                                            'wholesale_price_install' : '',
                                                            'wholesale_price_rental' : '',
                                                            'rrp_price_install' : '',
                                                            'rrp_price_rental' : '',
                                                        }, 
                                                        function() {
                                                            
                                                        }
                                                    );
                                                console.log(jsonData.TalkTalk.Options[i]);
                                            }
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