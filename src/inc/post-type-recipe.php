<?php
/**
 * Sets up recipe post type and adds necessary meta fields
 *
 * @package ohsheswooned
 */
add_action('init', 'ohsheswooned_create_recipe_post_type');

function ohsheswooned_create_recipe_post_type() {
  register_taxonomy_for_object_type('category', 'recipe'); // Register Taxonomies for Category
  register_taxonomy_for_object_type('post_tag', 'recipe');
  register_post_type( 'recipe',
    array(
      'labels' => array(
        'name' => __( 'Recipes' ),
        'singular_name' => __( 'Recipe' ),
      ),
      'description' => 'Fancy recipe listing for ohsheswooned blog',
      'public' => true,
      'has_archive' => false,
      'rewrite' => true,
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
      'register_meta_box_cb' => 'ohsheswooned_create_recipe_post_meta_boxes',
      'taxonomies' => array('post_tag', 'category')
    )
  );
  flush_rewrite_rules();
}

function ohsheswooned_create_recipe_post_meta_boxes() {
  add_meta_box('ohsheswooned-servings', 'Servings', 'ohsheswooned_print_servings_box', 'recipe', 'side');
  add_meta_box('ohsheswooned-cook-time', 'Cook time', 'ohsheswooned_print_time_box', 'recipe', 'side');
  add_meta_box('ohsheswooned-ingredients', 'Ingredients', 'ohsheswooned_print_ingredients_box', 'recipe', 'side');
  add_meta_box('ohsheswooned-instructions', 'Instructions', 'ohsheswooned_print_instructions_box', 'recipe', 'advanced');
}

function ohsheswooned_print_servings_box($post, $metabox) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'ohsheswooned_save_servings_meta_box_data', 'ohsheswooned_servings_meta_box_nonce' );

  $value = get_post_meta( $post->ID, '_ohsheswooned_servings_value_key', true );

  echo '<input type="text" id="ohsheswooned_servings_field" name="ohsheswooned_servings_field" value="' . esc_attr( $value ) . '" size="25" placeholder="Mary Elliott"/>';
}

function ohsheswooned_print_time_box($post, $metabox) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'ohsheswooned_save_time_meta_box_data', 'ohsheswooned_time_meta_box_nonce' );

  $value = get_post_meta( $post->ID, '_ohsheswooned_time_value_key', true );

  echo '<input type="text" id="ohsheswooned_time_field" name="ohsheswooned_time_field" value="' . esc_attr( $value ) . '" size="25" placeholder="I love you!"/>';
}

function ohsheswooned_print_ingredients_box($post, $metabox) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'ohsheswooned_save_ingredients_meta_box_data', 'ohsheswooned_ingredients_meta_box_nonce' );

  $ingredients = get_post_meta( $post->ID, '_ohsheswooned_ingredients_value_key', true );

  echo "<div class='ohsheswooned-ingredients-label'>
    <div class='ohsheswooned-ingredients-qty-label'>Qty</div>
    <div class='ohsheswooned-ingredients-text-label'>Name</div>
  </div>";

  $ingredients_counter = 0;

  echo '<div id="ohsheswooned-ingredients-listings">';
    if($ingredients) {
      foreach ($ingredients as $ingredient ) {
        $ingredient_qty = $ingredient['qty'];
        $ingredient_name = $ingredient['name'];
        echo "<div class='ohsheswooned-ingredient-listing'>
          <input class='ohsheswooned-ingredient-qty' value='$ingredient_qty' name='ohsheswooned_ingredients_field[$ingredients_counter][qty]'/>
          <input class='ohsheswooned-ingredient-name' value='$ingredient_name' name='ohsheswooned_ingredients_field[$ingredients_counter][name]'/>
        </div>";

        $ingredients_counter++;
      }
    }

    echo "<div class='ohsheswooned-ingredient-listing'>
        <input class='ohsheswooned-ingredient-qty' value='' name='ohsheswooned_ingredients_field[$ingredients_counter][qty]'/>
        <input class='ohsheswooned-ingredient-name' value='' name='ohsheswooned_ingredients_field[$ingredients_counter][name]'/>
      </div>
  </div>";

  $ingredients_counter++;

  echo '<a id="ohsheswooned-add-new-ingredient">Add new ingredient</a>';

  echo "<script>
    var ingredientCounter=$ingredients_counter;
    var $=jQuery;
    $('#ohsheswooned-add-new-ingredient').on('click', function(){
      var newIngredients = $('.ohsheswooned-ingredient-listing').first().clone();
      newIngredients.find('.ohsheswooned-ingredient-qty').attr('name', 'ohsheswooned_ingredients_field[' + ingredientCounter + '][qty]').attr('value', '');
      newIngredients.find('.ohsheswooned-ingredient-name').attr('name', 'ohsheswooned_ingredients_field[' + ingredientCounter + '][name]').attr('value', '');
      $('#ohsheswooned-ingredients-listings').append(newIngredients);
      ingredientCounter++;
    });
  </script>";

  echo "<style>
    #ohsheswooned-add-new-ingredient {
      cursor: pointer;
    }

    .ohsheswooned-ingredients-label {
      font-size: 0;
    }

    .ohsheswooned-ingredients-qty-label, .ohsheswooned-ingredients-text-label {
      font-size: 14px;
      display: inline-block;
    }

    .ohsheswooned-ingredients-qty-label {
      width: 60px;
    }

    .ohsheswooned-ingredient-qty {
      display: inline-block;
      width: 54px;
    }

    .ohsheswooned-ingredient-listing {
      margin-bottom: 3px;
    }

  </style>";
}

function ohsheswooned_print_instructions_box($post, $metabox) {
  wp_editor( get_post_meta( $post->ID, 'ohsheswooned_editor', true ), 'ohsheswooned_editor' );
}

add_action( 'save_post', 'ohsheswooned_save_servings_meta_box_data' );
add_action( 'save_post', 'ohsheswooned_save_time_meta_box_data' );
add_action( 'save_post', 'ohsheswooned_save_ingredients_meta_box_data' );
add_action( 'save_post', 'ohsheswooned_save_instructions_meta_box_data' );

function ohsheswooned_save_servings_meta_box_data( $post_id ) {
  // Check if our nonce is set.
  if ( ! isset( $_POST['ohsheswooned_servings_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['ohsheswooned_servings_meta_box_nonce'], 'ohsheswooned_save_servings_meta_box_data' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Make sure that it is set.
  if ( ! isset( $_POST['ohsheswooned_servings_field'] ) ) {
    return;
  }

  // Sanitize user input.
  $servings_data = sanitize_text_field( $_POST['ohsheswooned_servings_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, '_ohsheswooned_servings_value_key', $servings_data );
}

function ohsheswooned_save_time_meta_box_data( $post_id ) {
  // Check if our nonce is set.
  if ( ! isset( $_POST['ohsheswooned_time_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['ohsheswooned_time_meta_box_nonce'], 'ohsheswooned_save_time_meta_box_data' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Make sure that it is set.
  if ( ! isset( $_POST['ohsheswooned_time_field'] ) ) {
    return;
  }

  // Sanitize user input.
  $time_data = sanitize_text_field( $_POST['ohsheswooned_time_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, '_ohsheswooned_time_value_key', $time_data );

}

function ohsheswooned_save_ingredients_meta_box_data( $post_id ) {
  if ( ! isset( $_POST['ohsheswooned_ingredients_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['ohsheswooned_ingredients_meta_box_nonce'], 'ohsheswooned_save_ingredients_meta_box_data' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Make sure that it is set.
  if ( ! isset( $_POST['ohsheswooned_ingredients_field'] ) ) {
    return;
  }

  // Sanitize user input
  $ingredients_data =  $_POST['ohsheswooned_ingredients_field'];

  foreach($ingredients_data as $entry_key => $entry) {
    if($entry['qty'] === '' && $entry['name'] === '') {
      unset($ingredients_data[$entry_key]);
    }
  }

  update_post_meta($post_id, '_ohsheswooned_ingredients_value_key', $ingredients_data);
}

function ohsheswooned_save_instructions_meta_box_data( $post_id ) {
  update_post_meta( $post_id, 'ohsheswooned_editor', stripslashes( $_POST['ohsheswooned_editor'] ) );
}

function ohsheswooned_has_ingredients($ID) {
  return get_post_meta( $ID, '_ohsheswooned_ingredients_value_key', true);
}

function ohsheswooned_print_ingredients($ingredients) {
  foreach($ingredients as $ingredient) {
    $ingredient_qty = $ingredient['qty'];
    $ingredient_name = $ingredient['name'];
    echo "<div class='ingredient-line'>
      <span class='ingredient-qty'>$ingredient_qty</span>
      <span class='ingredient-name'>$ingredient_name</span>
    </div>";
  }
}
