
<div id="store" class="grid catalogue">

    <div class="catalogue__filters grid__item">

        <form id="filter" action="" method="">
	        <!-- The below search field is nice but needs work, it only searches currently displayed products, not hidden ones -->
			<!-- <input class="search" placeholder="Search" /> -->

            <fieldset>
                <legend>Sort</legend>
                <ul>
                    <li><input type="radio" name="sort" class="sort" id="sort--price" data-sort="price"><label for="sort--price">Sort by Price</label></li>
                    <li><input type="radio" name="sort" class="sort" id="sort--alpha" data-sort="product-title"><label for="sort--alpha">Sort Alphabetically</label></li>
                </ul>
            </fieldset>

            <fieldset>
                <legend>Filter</legend>
                <button id="clear-selected" class="btn btn--primary">Clear Selected</button>

                <fieldset>
                    <legend>Catergories</legend>
                    <ul>
						<?php
						// Create an array of all product_category taxonomies
							$args = array(
							  'taxonomy'     => 'product_category',
							  'orderby'      => 'name',
							);
							$cats_list = get_categories( $args );

							// Loop through the array and create input checkboxs with them
							foreach( $cats_list as $cat ) {
								$category = $cat->slug;
		                    	echo '<li>
                                        <input type="checkbox" id="' . $category . '" value="' . $category . '">
                                        <label for="' . $category . '">' . ucwords( str_replace("-", " ", $category) ) . '</label>
                                    </li>';
		                    	// unset the variable as its good practice
		                    	unset($cat);
		                    }

						?>
                    </ul>
                </fieldset>

                <fieldset>
                    <legend>Brands</legend>
                    <ul>
						<?php
							// Create an array of all product_brand taxonomies
							$args = array(
							  'taxonomy'     => 'product_brand',
							  'orderby'      => 'name',
							);
							$cats_list = get_categories( $args );

							// Loop through the array and create input checkboxs with them
							foreach( $cats_list as $cat ) {
								$brand = $cat->slug;
		                    	echo '<li>
                                        <input type="checkbox" id="' . $brand . '" value="' . $brand . '">
                                        <label for="' . $brand . '">' . ucwords( str_replace("-", " ", $brand) ) . '</label>
                                    </li>';
		                    	// unset the variable as its good practice
		                    	unset($cat);
		                    }
						?>
                    </ul>
                </fieldset>

            </fieldset>

        </form>

    </div><!--

 --><div class="catalogue__products grid__item">

        <ul class="list">
            <?php
                $argument = array(
                  'post_type' => 'product'
                );
                $products = new WP_Query( $argument );
                if( $products->have_posts() ) {
                  while( $products->have_posts() ) {
                    $products->the_post();

                    $id = $post->ID;

                    // Get catergorie(s) for post/product
                    $terms = get_the_terms( $id , 'product_category' );
                    // Loop over each item since it's an array
                    foreach( $terms as $term ) {
                    	// Asign the output to the $catergories variable
                    	$catergories = $term->slug . ' ';
                    	// unset the variable so it can be re-used below
                    	unset($term);
                    }

                    // Get Brand(s) for post/product
                    $terms = get_the_terms( $id , 'product_brand' );
                    // Loop over each item since it's an array
                    foreach( $terms as $term ) {
                    	// Asign the output to the $brand variable
                    	$brand = $term->slug . ' ';
                    	// unset the variable as its good practice
                    	unset($term);
                    }

					$price = get_post_meta(get_the_ID(), 'product_price', true );

                    ?>
                        <li class="catalogue--product <?php echo $catergories . ' ' . $brand; ?>">
                            <?php the_post_thumbnail() ?>
                            <div class="product__text">
                                <h3 class="product-title"><?php the_title() ?></h3>
                                <p class="price"><?php echo $price ?></p>
                                <a href="<?php the_permalink( $id ) ?>">Find out more</a>
                            </div>
                        </li>

                    <?php
                  }
                }
                else {
                  echo 'There are currently no products to display.';
                }
            ?>
        </ul> <!-- End Grid -->

    </div> <!-- End Products pane -->

</div>
