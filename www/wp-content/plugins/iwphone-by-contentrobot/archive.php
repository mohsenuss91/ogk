<?php get_header(); ?><div id="mainwrapper" class="clearfix">	<div id="maincontent">		<?php if (have_posts()) : ?>			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>			<?php /* If this is a category archive */ if (is_category()) { ?>			<h2 class="pagetitle">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>			<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>			<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>			<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>			<?php /* If this is a search */ } elseif (is_search()) { ?>			<h2 class="pagetitle">Search Results</h2>			<?php /* If this is an author archive */ } elseif (is_author()) { ?>			<h2 class="pagetitle">Author Archive</h2>			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>			<h2 class="pagetitle">Blog Archives</h2>			<?php } ?>			<?php while (have_posts()) : the_post(); ?>			<div class="post posthome">            	<div class="posthit" onclick="location.href='<?php the_permalink() ?>'">                    <h2 id="post-<?php the_ID(); ?>" class="thetitle"><?php /*?><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php */?><?php the_title(); ?><?php /*?></a><?php */?></h2>                    <div class="postinfo"><?php the_time('F jS, Y') ?> by <?php the_author() ?></div>                				<div class="entry">					<?php /*?><?php the_content(''); ?><?php */?>					<?php the_excerpt(); ?>                    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">Read the Entire Post ></a>				</div>				<p class="postmetadata">Posted in <?php the_category(' | ') ?></p>				<!--				<?php trackback_rdf(); ?>				-->                </div>			</div>			<?php endwhile; ?>								<?php 				$max_num_pages = $wp_query->max_num_pages;				if($max_num_pages > 1) { 				?>				<div class="prevnextnavigation clearfix">                	<div class="alignleft"><?php posts_nav_link('','','&laquo; Previous Entries') ?></div>                	<div class="alignright"><?php posts_nav_link('','Next Entries &raquo;','') ?></div>            	</div>				<?php }else{ } ?>						<?php else : ?>				<div class="post">                    <div class="postnohit">                        <h2 class="pagetitle">Not Found</h2>                    </div>                </div>		<?php endif; ?>	</div></div><?php get_footer(); ?>