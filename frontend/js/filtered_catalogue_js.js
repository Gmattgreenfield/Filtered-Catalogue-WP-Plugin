
// List.js plugin sort options
    var options = {
      valueNames: [ 'product-title', 'price' ]
    };
    var productList = new List('store', options);


// Filters
// Hide and show products when checkbox checked


$( document ).ready (function() {

    // Hide all products before page load
    $('.catalogue--product').hide();



    // Toggle hide / show on checkbox click
    $( "input[type=checkbox]" ).change(function() {
        // Get the id of the clicked checkbox
        var category = $(this).attr("id");

        // Show or Hide elements with the above ID as a class name
        $('.' + category).fadeToggle();

    });

    // Because sometimes the box may be checked before the document is ready, or it may be prefilled and not clicked (eg. when the back button is used)
    $("input[type='checkbox']:checked").each(function() {
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



});