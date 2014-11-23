
// List.js plugin sort options
    var options = {
      valueNames: [ 'product-title', 'price' ]
    };
    var productList = new List('store', options);


// Hide and show products when checkbox checked

$( document ).ready (function() {

    // Hide all products on page load
    $('.catalogue--product').hide();

    // Filters
    $( "input[type=checkbox]" ).click(function() {
        // Get the id of the clicked checkbox
		var category = $(this).attr("id");

        // Show or Hide elements with the above ID as a class name
        $('.' + category).fadeToggle();

    });


    // 'Clear Selected' Button
    $( "#clear-selected" ).click(function() {
        // Hide all products
        $('.catalogue--product').fadeOut();

        // Uncheck all the boxes
        $('input:checkbox').prop('checked', false);

        // Prevent the button from reloading page
        return false;
    });


    // Expand collapsed fieldsets when legen is clicked
    // Uses CSS that applies to small screens only
    // See fieldset.catalogue__filters--expanded css class
    $('legend').click(function() {
      $(this).parent().toggleClass('catalogue__filters--expanded');
    });

});