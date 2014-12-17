
// List.js plugin sort options
	var options = {
	  valueNames: [ 'product-title', 'price' ]
	};
	var productList = new List('store', options);






// Filters
// Hide and show products when checkbox checked

function toggleSelectState(type) {

    if(type != "category" && type != "brand")  {
        return; // stop the function.
    }

    // Get the value name of the clicked checkbox
    var checkboxValue = $(this).attr("value");

    if(!checkboxValue) {
        return;
    }

    // Show or Hide elements with the above value as a class name
    $('.' + checkboxValue).toggleClass( type + "-is-visible" );

    if ( $(".catalogue__product").hasClass( type + "-is-visible") ) {
        // if any [type] checkboxes are checked
        $('.catalogue__product').removeClass( type + "-not-selected" );
    } else {
        // if none are checked
        $('.catalogue__product').addClass( type + "-not-selected" );
    }
};



$( document ).ready (function() {


// Run the toggle class functions on checkbox change
	$( ".checkbox--category" ).change( toggleSelectState("category") );
	$( ".checkbox--brand" ).change( toggleSelectState("brand") );


// Because sometimes the box may be checked before the document is ready, or it may be prefilled and not clicked (eg. when the back button is used)
	$(".checkbox--catergory:checked").each( toggleSelectState("category") );
	$(".checkbox--brand:checked").each( toggleSelectState("brand") );


// 'Clear Selected' Button
	$( "#clear-selected" ).click(function() {
		// Hide all products
		$(".catalogue__product").removeClass( "category-is-visible" );
		$(".catalogue__product").removeClass( "brand-is-visible" );

		$('.catalogue__product').addClass( "category-not-selected" );
		$('.catalogue__product').addClass( "brand-not-selected" );

		// Uncheck all the boxes
		$('input:checkbox').prop('checked', false);

		// Prevent the button from reloading page
		return false;
	});

});
