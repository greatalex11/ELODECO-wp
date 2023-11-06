<?php

/**
 * Plugin Name: PERSO1-Promote Plugin
 * Description: Essai implemnent php
 * Version: 1.0
 * Author: Alex
 * Author URI: /
 **/

function plugin_ajout_txtpage()
{
   add_options_page(
      'sans nom',
      'Promo',
      0,
      "menu-slug",
      'mon_plugin_promo_id_html',
      10,
   );
}
add_action('admin_menu', 'plugin_ajout_txtpage');


function mon_plugin_promo_id_html()
{

   /* if (!current_user_can('manage_config')) {
      return;
   }*/

   if (isset($_POST['mon-plugin-promo'])) {
      $options = sanitize_text_field($_POST['mon-plugin-promo']);
      update_option('mon_plugin_ajout_texte_options', $options);
      echo '<div class="note notice-success"> <p> options enregistrées avec succes. </p> </div>';
   }

   $options = get_option('mon_plugin_ajout_texte_options', '');

?>
   <div class="wrap">
      <h1>Promotion plugin</h1>
      <form method="post">
         <label for="mon-plugin-promo">Texte de la promo</label>
         <input type="text" name="mon-plugin-promo" id="mon-plugin-promo" value="<?php echo esc_attr($options); ?>" class="regular_text">
         <input type="submit" value="Submit" name="mon-plugin-promo">

         <?php submit_button('Enregistrer les options', 'primary', 'submit', true); ?>
      </form>
   </div>
<?php
};

function mon_plugin_promo($the_content)
{
   /*if (is_home()) {
      
   }
   return $the_content;*/
   if (is_page('home')) {
      $options = get_option('mon_plugin_ajout_texte_options', '');
      $add = '<p class="promo">' . esc_html($options) . '</p>';
      $content = $add . $the_content;
      return $content;
   }
   return $the_content;
}

add_filter('the_content', 'mon_plugin_promo');

function promo_style()
{
   wp_enqueue_style('promo', plugin_dir_url(__FILE__) . '/promo.css');
}
add_action('wp_enqueue_scripts', 'promo_style');

/*function show_post($path)
{
   $post = get_page_by_path($path);
   $content = apply_filters('the_content', $post->post_content);
   echo $content;
}

show_post('home');*/

?>