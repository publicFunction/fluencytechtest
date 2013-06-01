jQuery(document).ready(function($) {
    
    $('li div.remove input.delete_quote').on('click', function() {
        console.log($(this).attr('id'));
        var quote = $(this).attr('id').replace('delete_', '');
        console.log(quote);
        var del_conf = confirm("Are you sure you want to delete this quote?");
        console.log(del_conf);
        if (del_conf == true) {
            $.post( 'ajax/processajax.php',
                    {
                        'action' : 'deleteQuote',
                        'quote' : quote
                    },
                    function() {
                        location.reload();
                    }
            );
        }
        
        return false;
    });
    
    /*  Full Ajax on the quote system and processes eveything in one fail swoop */
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
                                        if (jsonData.Openreach) {
                                            for (i = 0; i < jsonData.Openreach.Options.length; i++) {
                                                var buy_price;
                                                var bandwidthInt = parseFloat(jsonData.Openreach.Options[i].Bandwidth.replace('Mb', ''));
                                                
                                                switch($('select#contract_length').val()) {
                                                    case "12":
                                                        buy_price = jsonData.Openreach.Options[i].Install12Months;
                                                        break;
                                                    case "36":
                                                        buy_price = jsonData.Openreach.Options[i].Install36Months;
                                                        if (buy_price == "0") {
                                                            buy_price = jsonData.Openreach.Options[i].Install12Months;
                                                        }
                                                        break;
                                                    default:
                                                        buy_price = jsonData.Openreach.Options[i].Install12Months;
                                                        break;
                                                }
                                                
                                                var rental_price = parseFloat(jsonData.Openreach.Options[i].Rental);
                                                
                                                if (rental_price < 3000) {
                                                    rental_price = 3000;
                                                }
                                                
                                                var wholesale_price_install_perc = (buy_price + (bandwidthInt * 14.40) * 25) / 100;
                                                var wholesale_price_rental_perc = (rental_price + (bandwidthInt * 14.40) * 25) / 100;
                                                var wholesale_price_install = buy_price + wholesale_price_install_perc;
                                                var wholesale_price_rental = rental_price + wholesale_price_rental_perc;
                                                var rrp_price_install = wholesale_price_install + (wholesale_price_install * 25 / 100);
                                                var rrp_price_rental = wholesale_price_rental + (wholesale_price_rental * 25 / 100);

                                                $.post( 'ajax/processajax.php', 
                                                        {
                                                            'action' : 'createQuote',
                                                            'ethernet_quote_id' : $.cookie("master_quote"),
                                                            'site_name' : $.cookie("site_name"),
                                                            'postcode' : $.cookie("postcode"),
                                                            'bandwidth' : jsonData.Openreach.Options[i].Bandwidth,
                                                            'bearer' : jsonData.Openreach.Options[i].Bearer,
                                                            'carrier' : 'Openreach',
                                                            'buy_price_install' : buy_price.toFixed(2),
                                                            'buy_price_rental' : jsonData.Openreach.Options[i].Rental,
                                                            'wholesale_price_install' : wholesale_price_install.toFixed(2),
                                                            'wholesale_price_rental' : wholesale_price_rental.toFixed(2),
                                                            'rrp_price_install' : rrp_price_install.toFixed(2),
                                                            'rrp_price_rental' : rrp_price_rental.toFixed(2),
                                                        }, 
                                                        function() {
                                                            
                                                        }
                                                    );
                                            }
                                            
                                        }
                                        if (jsonData.TalkTalk) {
                                            for (i = 0; i < jsonData.TalkTalk.Options.length; i++) {
                                                var buy_price;
                                                var bandwidthInt = parseFloat(jsonData.TalkTalk.Options[i].Bandwidth.replace('Mb', ''));
                                                
                                                switch($('select#contract_length').val()) {
                                                    case "12":
                                                        buy_price = parseFloat(jsonData.TalkTalk.Options[i].Install12Months);
                                                        break;
                                                    case "36":
                                                        buy_price = parseFloat(jsonData.TalkTalk.Options[i].Install36Months);
                                                        if (buy_price == "0") {
                                                            buy_price = parseFloat(jsonData.TalkTalk.Options[i].Install12Months);
                                                        }
                                                        break;
                                                    default:
                                                        buy_price = parseFloat(jsonData.TalkTalk.Options[i].Install12Months);
                                                        break;
                                                }
                                                
                                                var rental_price = parseFloat(jsonData.TalkTalk.Options[i].Rental);
                                                
                                                if (rental_price < 3000) {
                                                    rental_price = 3000;
                                                }
                                                
                                                var wholesale_price_install_perc = (buy_price + (bandwidthInt * 14.40) * 25) / 100;
                                                var wholesale_price_rental_perc = (rental_price + (bandwidthInt * 14.40) * 25) / 100;
                                                var wholesale_price_install = buy_price + wholesale_price_install_perc;
                                                var wholesale_price_rental = rental_price + wholesale_price_rental_perc;
                                                var rrp_price_install = wholesale_price_install + (wholesale_price_install * 25 / 100);
                                                var rrp_price_rental = wholesale_price_rental + (wholesale_price_rental * 25 / 100);
                                                
                                                $.post( 'ajax/processajax.php', 
                                                        {
                                                            'action' : 'createQuote',
                                                            'ethernet_quote_id' : $.cookie("master_quote"),
                                                            'site_name' : $.cookie("site_name"),
                                                            'postcode' : $.cookie("postcode"),
                                                            'bandwidth' : jsonData.TalkTalk.Options[i].Bandwidth,
                                                            'bearer' : jsonData.TalkTalk.Options[i].Bearer,
                                                            'carrier' : 'TalkTalk',
                                                            'buy_price_install' : buy_price.toFixed(2),
                                                            'buy_price_rental' : jsonData.TalkTalk.Options[i].Rental,
                                                            'wholesale_price_install' : wholesale_price_install.toFixed(2),
                                                            'wholesale_price_rental' : wholesale_price_rental.toFixed(2),
                                                            'rrp_price_install' : rrp_price_install.toFixed(2),
                                                            'rrp_price_rental' : rrp_price_rental.toFixed(2),
                                                        }, 
                                                        function() {
                                                            
                                                        }
                                                    );
                                            }
                                        }
                                        /*  Set Forwarder   */
                                        location.href = "index2.php";
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