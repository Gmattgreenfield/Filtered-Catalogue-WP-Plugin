<?php get_header(); ?>

<?php

	$price = get_post_meta(get_the_ID(), 'product_price', true );

?>

<h1 class="product-title"><?php the_title() ?></h1>

<section class="entry-content">

	<div class="grid">

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="grid__item one-half palm-one-whole"> <?php the_post_thumbnail() ?> </div><!--

			--><?php
		} ?><div class="grid__item <?php if ( has_post_thumbnail() ) { ?> one-half <?php } ?>">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<?php the_content(); ?>
			</div>
			<?php endwhile; endif; ?>

			<p class="price"><?php echo $price ?></p>

		</div>

	</div> <!-- End Grid -->

<div class="entry-links"><?php wp_link_pages(); ?></div>
</section>

<?php get_footer(); ?>
