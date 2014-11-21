
    // List.js plugin sort options
    var options = {
      valueNames: [ 'product-title', 'price' ]
    };
    var productList = new List('store', options);

    // Hide all products on page load
    $('.product').hide();

    // Filters
    $( "input[type=checkbox]" ).click(function() {
        // Get the id of the clicked checkbox
		var category = $(this).attr("id");

        // add or remove the .visable class to any element with the above ID as a class name
        if ($(this).is(':checked')) {
            $('.' + category)
                /* Use jQuery's $.show() function to make the element visible by switching its display property to "block"/"inline" as appropriate. */
                .show()
                /* Fade in and slide into view. */
                .animate({
                    opacity: 1,
                });
    	} else {
            $('.' + category)
                .hide()
                .animate({
                    opacity: 0,
                });
        }
    });


    // 'Clear Selected' Button
    $( "#clear-selected" ).click(function() {
        // Hide all products
        $('.product').hide();
        // Uncheck all the boxes
        $('input:checkbox').prop('checked', false);
        // Prevent the button from reloading page
        return false;
    });


    // Expand fieldsets when clicked
    // Uses CSS that applies to small screens only
    // See fieldset.catalogue__filters--expanded css class
    $('legend').click(function() {
      $(this).parent().toggleClass('catalogue__filters--expanded');
    });