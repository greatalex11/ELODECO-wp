<?php

/**
 * The main single item template file.
 *
 * @package kadence
 */

namespace Kadence;

if (!defined('ABSPATH')) {
	exit;
}
get_header();
?>
<div id="main-content" class="article-wrapper">
	<?php
	while (have_posts()) : the_post();
	?>
		<p>"SINGLE PERSONNALISE" </p>
</div>
<?php endwhile; ?>

<?php
kadence()->print_styles('kadence-content');
/**
 * Hook for everything, makes for better elementor theming support.
 */
do_action('single-projet');
$test = get_field('titre');
echo $test;
get_footer();
?>