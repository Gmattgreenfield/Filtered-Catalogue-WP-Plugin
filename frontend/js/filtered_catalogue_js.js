
// List.js plugin sort options
	var options = {
	  valueNames: [ 'product-title', 'price' ]
	};
	var productList = new List('store', options);






// Filters
// Hide and show products when checkbox checked


function toggleCategory() {
	// Get the id of the clicked checkbox
	var category = $(this).attr("value");

	// Show or Hide elements with the above ID as a class name
	$('.' + category).toggleClass( "category-is-visable" );

	if ( $(".catalogue__product").hasClass("category-is-visable") ) {
	    // if any category checkboxes are checked
	    $('.catalogue__product').removeClass( "category-not-selected" );
	} else {
		// if none are checked
		$('.catalogue__product').addClass( "category-not-selected" );
	}
};


function toggleBrand() {
	// Get the id of the clicked checkbox
	var brand = $(this).attr("value");

	// Show or Hide elements with the above ID as a class name
	$('.' + brand).toggleClass( "brand-is-visable" );


	if ( $(".catalogue__product").hasClass("brand-is-visable") ) {
	    // if any brand checkboxes are checked
	    $('.catalogue__product').removeClass( "brand-not-selected" );
	} else {
		// if none are checked
		$('.catalogue__product').addClass( "brand-not-selected" );
	}
};


$( document ).ready (function() {


// Run the toggle class functions on checkbox change
	$( ".checkbox--category" ).change(toggleCategory);
	$( ".checkbox--brand" ).change(toggleBrand);


// Because sometimes the box may be checked before the document is ready, or it may be prefilled and not clicked (eg. when the back button is used)
	$(".checkbox--catergory:checked").each(toggleCategory);
	$(".checkbox--brand:checked").each(toggleBrand);


// 'Clear Selected' Button
	$( "#clear-selected" ).click(function() {
		// Hide all products
		$(".catalogue__product").removeClass( "category-is-visable" );
		$(".catalogue__product").removeClass( "brand-is-visable" );

		$('.catalogue__product').addClass( "category-not-selected" );
		$('.catalogue__product').addClass( "brand-not-selected" );

		// Uncheck all the boxes
		$('input:checkbox').prop('checked', false);

		// Prevent the button from reloading page
		return false;
	});

});
