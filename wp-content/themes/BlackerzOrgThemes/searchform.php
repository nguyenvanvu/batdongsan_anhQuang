					<form class="search-form" method="get" action="<?php echo home_url(); ?>/">
						<input type="text" placeholder="<?php echo __("Search...", "delicious"); ?>" id="s" name="s" value="<?php the_search_query(); ?>" />
						<button type="submit" value="Search"><i class="fa fa-search"></i></button>
					</form>