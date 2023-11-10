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
		<p>"coucou" <?php echo "coucou"; ?> </p>

</div>
<?php endwhile; ?>
MON THEME ADORE
<?php
kadence()->print_styles('kadence-content');
/**
 * Hook for everything, makes for better elementor theming support.
 */
do_action('single-projet');
$test = get_field('field_653919e92760e');
echo $test;
var_dump($test);
get_footer();
?>