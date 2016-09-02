<?php
/**
 * Sets up recipe post type and adds necessary meta fields
 *
 * @package ohsheswooned
 */
add_action('init', 'oss_create_recipe_post_type');

function oss_create_recipe_post_type() {
  register_taxonomy_for_object_type('category', 'oss_recipe'); // Register Taxonomies for Category
  register_taxonomy_for_object_type('post_tag', 'oss_recipe');
  register_post_type( 'oss_recipe',
    array(
      'labels' => array(
        'name' => __( 'Recipes' ),
        'singular_name' => __( 'Recipe' ),
      ),
      'description' => 'Fancy recipe listing for ohsheswooned blog',
      'public' => true,
      'has_archive' => true,
      'rewrite' => array(
        'slug' => 'recipes'
      ),
      'menu_position' => 5,
      'menu_icon' => 'dashicons-carrot',
      'supports' => array(
        'title',
        'editor',
        'author',
        'custom-fields',
        'comments',
        'revisions',
        'thumbnail',
        'excerpt'
      ),
      'register_meta_box_cb' => 'oss_create_recipe_post_meta_boxes',
      'taxonomies' => array('post_tag', 'category')
    )
  );
}

function oss_create_recipe_post_meta_boxes() {
  add_meta_box('oss-servings', 'Servings', 'oss_print_servings_box', 'oss_recipe', 'side');
  add_meta_box('oss-cook-time', 'Cook time', 'oss_print_time_box', 'oss_recipe', 'side');
  add_meta_box('oss-ingredients', 'Ingredients', 'oss_print_ingredients_box', 'oss_recipe', 'side');
}

function oss_print_servings_box($post, $metabox) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'oss_save_servings_meta_box_data', 'oss_servings_meta_box_nonce' );

  $value = get_post_meta( $post->ID, '_oss_servings_value_key', true );

  echo '<input type="text" id="oss_servings_field" name="oss_servings_field" value="' . esc_attr( $value ) . '" size="25" placeholder="Mary Elliott"/>';
}

function oss_print_time_box($post, $metabox) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'oss_save_time_meta_box_data', 'oss_time_meta_box_nonce' );

  $value = get_post_meta( $post->ID, '_oss_time_value_key', true );

  echo '<input type="text" id="oss_time_field" name="oss_time_field" value="' . esc_attr( $value ) . '" size="25" placeholder="I love you!"/>';
}

function oss_print_ingredients_box($post, $metabox) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'oss_save_ingredients_meta_box_data', 'oss_ingredients_meta_box_nonce' );

  $ingredients = get_post_meta( $post->ID, '_oss_ingredients_value_key', true );

  echo "<div class='oss-ingredients-label'>
    <div class='oss-ingredients-qty-label'>Qty</div>
    <div class='oss-ingredients-text-label'>Name</div>
  </div>";

  $ingredients_counter = 0;

  echo '<div id="oss-ingredients-listings">';
    if($ingredients) {
      foreach ($ingredients as $ingredient ) {
        $ingredient_qty = $ingredient['qty'];
        $ingredient_name = $ingredient['name'];
        echo "<div class='oss-ingredient-listing'>
          <input class='oss-ingredient-qty' value='$ingredient_qty' name='oss_ingredients_field[$ingredients_counter][qty]'/>
          <input class='oss-ingredient-name' value='$ingredient_name' name='oss_ingredients_field[$ingredients_counter][name]'/>
        </div>";

        $ingredients_counter++;
      }
    }

    echo "<div class='oss-ingredient-listing'>
        <input class='oss-ingredient-qty' value='' name='oss_ingredients_field[$ingredients_counter][qty]'/>
        <input class='oss-ingredient-name' value='' name='oss_ingredients_field[$ingredients_counter][name]'/>
      </div>
  </div>";

  $ingredients_counter++;

  echo '<a id="oss-add-new-ingredient">Add new ingredient</a>';

  echo "<script>
    var ingredientCounter=$ingredients_counter;
    var $=jQuery;
    $('#oss-add-new-ingredient').on('click', function(){
      var newIngredients = $('.oss-ingredient-listing').first().clone();
      newIngredients.find('.oss-ingredient-qty').attr('name', 'oss_ingredients_field[' + ingredientCounter + '][qty]').attr('value', '');
      newIngredients.find('.oss-ingredient-name').attr('name', 'oss_ingredients_field[' + ingredientCounter + '][name]').attr('value', '');
      $('#oss-ingredients-listings').append(newIngredients);
      ingredientCounter++;
    });
  </script>";

  echo "<style>
    #oss-add-new-ingredient {
      cursor: pointer;
    }

    .oss-ingredients-label {
      font-size: 0;
    }

    .oss-ingredients-qty-label, .oss-ingredients-text-label {
      font-size: 14px;
      display: inline-block;
    }

    .oss-ingredients-qty-label {
      width: 60px;
    }

    .oss-ingredient-qty {
      display: inline-block;
      width: 54px;
    }

    .oss-ingredient-listing {
      margin-bottom: 3px;
    }

  </style>";
}

add_action( 'save_post', 'oss_save_servings_meta_box_data' );
add_action( 'save_post', 'oss_save_time_meta_box_data' );
add_action( 'save_post', 'oss_save_ingredients_meta_box_data' );

function oss_save_servings_meta_box_data( $post_id ) {
  // Check if our nonce is set.
  if ( ! isset( $_POST['oss_servings_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['oss_servings_meta_box_nonce'], 'oss_save_servings_meta_box_data' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Make sure that it is set.
  if ( ! isset( $_POST['oss_servings_field'] ) ) {
    return;
  }

  // Sanitize user input.
  $servings_data = sanitize_text_field( $_POST['oss_servings_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, '_oss_servings_value_key', $servings_data );
}

function oss_save_time_meta_box_data( $post_id ) {
  // Check if our nonce is set.
  if ( ! isset( $_POST['oss_time_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['oss_time_meta_box_nonce'], 'oss_save_time_meta_box_data' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Make sure that it is set.
  if ( ! isset( $_POST['oss_time_field'] ) ) {
    return;
  }

  // Sanitize user input.
  $time_data = sanitize_text_field( $_POST['oss_time_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, '_oss_time_value_key', $time_data );

}

function oss_save_ingredients_meta_box_data( $post_id ) {
  if ( ! isset( $_POST['oss_ingredients_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['oss_ingredients_meta_box_nonce'], 'oss_save_ingredients_meta_box_data' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Make sure that it is set.
  if ( ! isset( $_POST['oss_ingredients_field'] ) ) {
    return;
  }

  // Sanitize user input
  $ingredients_data =  $_POST['oss_ingredients_field'];

  foreach($ingredients_data as $entry_key => $entry) {
    if($entry['qty'] === '' && $entry['name'] === '') {
      unset($ingredients_data[$entry_key]);
    }
  }

  update_post_meta($post_id, '_oss_ingredients_value_key', $ingredients_data);
}

function oss_has_ingredients($ID) {
  return get_post_meta( $ID, '_oss_ingredients_value_key', true);
}

function oss_print_ingredients($ingredients) {
  foreach($ingredients as $ingredient) {
    $ingredient_qty = $ingredient['qty'];
    $ingredient_name = $ingredient['name'];
    echo "<div class='ingredient-line'>
      <span class='ingredient-qty'>$ingredient_qty</span>
      <span class='ingredient-name'>$ingredient_name</span>
    </div>";
  }
}

/**
 * Add recipes to homepage loop
 */

add_action( 'pre_get_posts', 'include_recipes_in_home' );

function include_recipes_in_home( $query ) {

   if ( ! is_admin() && $query->is_main_query() && $query->is_home() ) {
       $query->set( 'post_type', array( 'post', 'oss_recipe' ) );
   }
}
