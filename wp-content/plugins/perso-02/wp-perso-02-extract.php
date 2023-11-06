
<?php

/**
 * Plugin Name: PERSO2-Extract JSON Plugin
 * Description: Extraction donnees Response WP
 * Version: 2.0
 * Author: Alex
 * Author URI: /
 **/

function plugin_ajout_txtpage2()
{
   add_options_page(
      'ma fonction extract',
      'Extract',
      0,
      "monAPI",
      'mon_plugin_extract2',
      10,
   );
}
add_action('admin_menu', 'plugin_ajout_txtpage2');

function mon_plugin_extract2()
{

   //gros grain : recup du gros json
   $endpoint = "http://localhost/wp-json/acf/v3/projet";
   $json = json_decode(file_get_contents($endpoint), true);
   dump($json);
}

/**
 *     GET REQUEST 
 * 
 **/

add_action(
   'rest_api_init',
   function () {
      //recuperation argument passe http ?P
      register_rest_route('wp/v2', '/projets', [
         'methods' => 'GET',
         'callback' => function (WP_REST_Request $request) {

            /*
            $posts = get_posts([
               'post_type' => 'projet',
               'post_status' => 'publish',
               'numberposts' => -1
            ]);
            return $posts;*/

            /*
            $args = array(
               'post_type' => 'projet',
               'meta_query' => array(
                  array(
                     'key' => 'projet',
                     //'value' => 'specific_value',
                     //'compare' => '='
                  )
               )
            );*/

            $postsAll = get_posts($args = null);
            var_dump($postsAll);
            die();
            $results = array();
            foreach ($postsAll as $post) {
               $results[] = array(
                  'ID' => $post->ID,
                  'title' => $post->titre,
                  'content' => $post->post_content,
                  'date' => $post->post_date,
                  'custom_field' => get_post_meta($post->ID, 'projetsChamps', true)
               );
               return $results;
            }
         }
      ]);
   }
);

/*
            $response = new WP_REST_Response(['sucess' => 'bonjour mon bel OBJET']);
            $response->set_status(201);

            $results = array();
            foreach ($response as $projets) {
               $results[] = array(
                  'ID' => $projets->id,
                  'title' => $projets->titre,
                  'content' => $projets->descritptif,
                  'date' => $projets->adresse,
                  // 'custom_field' => get_post_meta($post->ID, 'projetsChamps', true)
               );
               return $results;*/




/* **************************************************************************************************************** */




//init API et access API via 'admin/api'

add_action(
   'rest_api_init',
   function () {
      //recuperation argument passe http ?P
      register_rest_route('monAPI/v1', '/data/(?P<numPost>\d+)', [
         'methods' => 'GET',
         'callback' => function (WP_REST_Request $request) {
            $numPost = ((int) $request->get_param('numPost'));
            $post = get_post($numPost);
            return $post->titre;
            die();
            //essai avec l'objet Response
            $response = new WP_REST_Response(['sucess' => 'bonjour mon bel OBJET']);
            $response->set_status(201);

            return $response;
         }
      ]);
   }
);


/**
 *    POSTS METHODS
 * 
 **/

add_action(
   'rest_api_init',
   function () {
      //array args -> recherche data via QUERY ou GET_POST


      register_rest_route('monAPI/v1', '/data/all', [
         'methods' => 'GET',
         'callback' => function () {

            global $args;

            $args = array(
               'post_type' => 'projetsChamps',
               'meta_query' => array(
                  array(
                     'key' => 'projet',
                     //'value' => 'specific_value',
                     //'compare' => '='
                  )
               )
            );

            $postsAll = get_posts($args);

            $results = array();
            foreach ($postsAll as $post) {
               $results[] = array(
                  'ID' => $post->ID,
                  'title' => $post->post_title,
                  'content' => $post->post_content,
                  'date' => $post->post_date,
                  'custom_field' => get_post_meta($post->ID, 'projetsChamps', true)
               );
               return $results;
            }
         }
      ]);
   }
);

/**
 *    QUERY METHODS
 * 
 **/

add_action(
   'rest_api_init',
   function () {

      register_rest_route('monAPI/v1', '/data/query', [
         'methods' => 'GET',
         'callback' => function () {


            $args = array(
               'post_type' => 'projetsChamps',
               'meta_query' => array(
                  array(
                     'key' => 'projet',
                     //'value' => 'specific_value',
                     //'compare' => '='
                  )
               )
            );


            $query = new WP_Query($args);

            $results = array();
            if ($query->have_posts()) {
               while ($query->have_posts()) {
                  $query->the_post();
                  $results[] = array(
                     'ID' => get_the_ID(),
                     'titre' => get_the_title(),
                     'content' => get_the_content(),
                     'date' => get_the_date()
                  );
               }
            }
            return array($results);
            wp_reset_postdata();
         }
      ]);
   }
);

            

/*
apiFetch( {
   path: '/wp/v2/posts/1',
   method: 'POST',
   data: { title: 'New Post Title' },
} ).then( ( res ) => {
   console.log( res );
} );


add_action( 'rest_api_init', function () {
 register_rest_field( 'post',
   'projetsChamps',
   array(
     'get_callback'   => 'get_projets_champs',
     'update_callback' => null,
     'schema'         => null,
   )
 );
} );

function get_projets_champs( $object, $field_name, $request ) {
 return get_post_meta( $object[ 'id' ], $field_name, true );
}


/wp/v2/posts/1?_fields=projetsChamps





*/
/*
function promo_style()
{
   wp_enqueue_style('promo', plugin_dir_url(__FILE__) . '/promo.css');
}
add_action('wp_enqueue_scripts', 'promo_style');
*/

/*function show_post($path)
{
   $post = get_page_by_path($path);
   $content = apply_filters('the_content', $post->post_content);
   echo $content;
}

show_post('home');*/
