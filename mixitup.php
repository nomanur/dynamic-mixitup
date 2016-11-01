<?php
//ata functions.php te dite hobe

Step# 01: Register Custom Post
******************************

# Register Custom Post
function wp_tutorials_post() {
    register_post_type( 'cluster-portfolio',
        array(
            'labels' => array(
                'name' => __( 'Portfolio' ),
                'singular_name' => __( 'Portfolio' ),
                'add_new' => __( 'Add New' ),
                'add_new_item' => __( 'Add New Portfolio' ),
            ),
        'public' => true,
        'supports' => array( 'title', 'editor', 'custom-fields','thumbnail')
        )
    );
}
add_action( 'init', 'wp_tutorials_post' );

********************************************************************************************************************************************


Step # 02: Register Custom Taxonomy For Portfolio
*************************************************   
    
# Register Custom Taxonomy For Portfolio
 
function wp_tutorials_post_taxonomy() {
    register_taxonomy(
        'cluster_portfolio_cat',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'cluster-portfolio',                  //post type name
        array(
            'hierarchical'          => true,
            'label'                         => 'Portfolio Category',  //Display name
            'query_var'             => true,
            'show_admin_column'             => true,
            'rewrite'                       => array(
                'slug'                  => 'portfolio-category', // This controls the base slug that will display before each term
                'with_front'    => true // Don't display the category base before
                )
            )
    );
}
add_action( 'init', 'wp_tutorials_post_taxonomy'); 


//End fanctions.php







//Step 3
**********
            <div class="portfolio-wrapper" >
                <?php $portfolio_cats = get_terms('cluster_portfolio_cat'); ?>
                <?php if (!empty($portfolio_cats) && !is_wp_error($portfolio_cats)) : ?>        
                    <div class="col-md-12">
                        <ul class="filter">              
                            <li><a class="active" href="#" data-filter="*">All</a></li>    

                            <?php foreach ($portfolio_cats as $portfolio_cat) : ?>
                                <li><a href="#" data-filter=".<?php echo $portfolio_cat->slug ?>"><?php echo $portfolio_cat->name ?></a></li>
                            <?php endforeach; ?>
                        </ul><!--/#portfolio-filter-->
                    </div>
                <?php endif; ?>

                <div class="portfolio-items">

                    <?php
                    global $post;
                    $args = array('posts_per_page' => -1, 'post_type' => 'cluster-portfolio', 'orderby' => 'menu_order', 'order' => 'ASC');
                    $myposts = get_posts($args);
                    foreach ($myposts as $post) : setup_postdata($post);
                        ?>

                        <?php
                        $terms = get_the_terms($post->ID, 'cluster_portfolio_cat');
                        ?>
                    
                    <?php
                        $terms = get_the_terms($post->ID, 'cluster_portfolio_cat');

                        if ($terms && !is_wp_error($terms)) :

                            $portfolio_cat_slug = array();
                            $portfolio_cat_name = array();

                            foreach ($terms as $term) {
                                $portfolio_cat_slug[] = $term->slug;
                            }

                            foreach ($terms as $term) {
                                $portfolio_cat_name[] = $term->name;
                            }

                            $portfolio_cat_array = join(", ", $portfolio_cat_slug);
                            $portfolio_class_array = join(" ", $portfolio_cat_slug);

                            $portfolio_assigned_list = join(", ", $portfolio_cat_name);
                        endif;
                        ?>

                        <div class="col-md-4 col-sm-6 work-grid <?php echo $portfolio_class_array; ?>">
                            <div class="portfolio-content">
                                <?php the_post_thumbnail('portfolio-thumb', array('class' => 'img-responsive')); ?>
                                <div class="portfolio-overlay">
                                    <a href="<?php echo $portfolio_large[0]; ?>"><i class="fa fa-camera-retro"></i></a>
                                    <h5><?php the_title(); ?></h5>
                                    <p><?php echo $portfolio_assigned_list; ?></p>
                                </div>
                            </div>	
                        </div>
                    <?php endforeach; ?>


                    

                </div>	