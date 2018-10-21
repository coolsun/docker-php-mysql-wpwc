<?php
/**
 * Template Name: Donee Profile
*
*/

get_header(); ?>

<div id="primary" class="content-area">
<div id="content" class="site-content" role="main">

<?php
/* The page content */
while ( have_posts() ) : the_post();
    $page_link = get_permalink();
    the_content();
endwhile;

$required_user = get_query_var( 'user' );

$wanted_meta = array(
    'first_name', // This is a standard meta
    'facebook',   // This is an example of custom meta
    'twitter'     // This is another example of custom meta
);

if ( empty( $required_user ) ) {

    /* The Users Loop */

    // Customize the args as you need
    $args = array (
        'role'    => 'gds24_donee_role',
        'orderby' => 'post_count',
        'order'   => 'DESC',
        'fields'  => 'all'
    );
    $user_query = new WP_User_Query( $args );
    if ( ! empty( $user_query->results ) ) { 
        foreach ( $user_query->results as $user ) {
            $profile_url = trailingslashit($page_link) . 'user/' . $user->user_nicename;
            // This gets ALL the meta fields as a 2 dimensional array (array of arrays)
            $meta_fields = get_user_meta( $user->ID ); 
            ?>
            <div id="user-<?php echo $user->ID ?>">
            <?php
            // An example of custom meta where to save the id of an attachment
            if ( isset($meta_fields['photo_id'][0]) && ! empty($meta_fields['photo_id'][0]) ) {
                echo '<a href="' . esc_url($profile_url) . '/">';
                echo wp_get_attachment_image( $meta_fields['photo_id'][0], 'medium' );
                echo '</a>';
            }
            ?>
            <h2><?php echo '<p><a href="' .esc_url( $profile_url ) . '/">' . 
                $user->display_name . '</a></p>';?></h2>
            <p><?php echo $meta_fields['description'][0]; ?></p>
            <ul>
            <?php
            foreach ( $wanted_meta as $key ) { 
                if ( isset($meta_fields[$key][0]) && ! empty($meta_fields[$key][0]) ) {
                    ?>
                    <li><?php echo $meta_fields[$key][0]; ?></li>
                <?php } 
            } ?>
            </ul>
            </div>
            <?php
        }
    }

} else {

    /* One User Requested */

    $user = get_user_by( 'slug', $required_user );
    if ( $user ) {
        ?>
        <div id="user-<?php echo $user->ID ?>">
        <?php
        $meta_fields = get_user_meta( $user->ID );
        if ( isset( $meta_fields['photo_id'][0] ) && ! empty( $meta_fields['photo_id'][0] ) ) {
            echo wp_get_attachment_image( $meta_fields['photo_id'][0], 'full' );
        }
        ?>
        <h1><?php echo '<p>' . $user->display_name . '</p>';?></h1>
        <p><?php echo $meta_fields['description'][0]; ?></p>
        <p>
            <a href="<?php echo get_author_posts_url($user->ID); ?>"><?php 
                printf(__('See all posts by %s'), $user->display_name); ?></a> | 
            <a href="<?php echo $page_link; ?>"><?php _e('Back to Staff'); ?></a>
        </p>
        <ul>
        <?php
        foreach ( $wanted_meta as $key ) {
            if ( isset( $meta_fields[$key][0] ) && ! empty( $meta_fields[$key][0] ) ) {
                ?>
                <li><?php echo $meta_fields[$key][0]; ?></li>
                <?php 
            } 
        } ?>
        </ul>
        </div>
        <?php
    }
}
?>

</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>