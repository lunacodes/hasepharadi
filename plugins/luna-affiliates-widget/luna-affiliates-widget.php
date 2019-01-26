<?php

class Luna_AFL_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'Luna_AFL_Widget',  // Base ID
            'Luna Affiliates Widget'   // Name
        );

        // register Luna_AFL_Widget
        add_action( 'widgets_init', function() {
            register_widget( 'Luna_AFL_Widget' );
        });

    }

    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap afl-container">',
        'after_widget'  => '</div></div>'
    );

    /**
     * Affiliates Widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        // print_r($args);
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $before_widget;

        if ( ! empty ($title ) ) {
            echo $before_title . $title . $after_title;
        }

        $user_id = get_the_author_meta( 'ID' );
        $user_acf_prefix = 'user_';
        $user_id_prefixed = $user_acf_prefix . $user_id;

        // Debugging
        // echo("$user_id, $user_acf_prefix, $user_id_prefixed");
        ?>
        <div class="luna-afl affiliates-container">
        <?php
        if ( have_rows( 'affiliate_links', $user_id_prefixed ) ) :
             while ( have_rows( 'affiliate_links', $user_id_prefixed ) ) : the_row();

                $affiliate_image = get_sub_field( 'affiliate_image' );

                // Debugging
                // var_dump($affiliate_image);

                // thumbnail
                $size = 'medium';
                $thumb = $affiliate_image['sizes'][ $size ];
                $width = $affiliate_image['sizes'][ $size . '-width' ];
                $height = $affiliate_image['sizes'][ $size . '-height' ];
                ?>

                <div class="affiliate-item">
                    <figure>
                        <a href="<?php the_sub_field( 'affiliate_url' ); ?>" class="affiliate-img-link">
                            <img class="affiliate-img"src="<?php echo $affiliate_image['url']; ?>" alt="<?php echo $affiliate_image['alt']; ?>" width="<?php echo($width); ?>" height="<?php echo($height); ?>" />
                        </a>
                            <figcaption class="affiliate-link-text"><?php the_sub_field( 'affiliate_link_text' ); ?></figcaption>
                    </figure>

                </div>
                <?php

            endwhile;
        endif;
        ?>
    </div>
    <?php
        echo $after_widget;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'luna_afl' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'luna_afl' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }

} // class Luna_AFL_Widget
$luna_afl_widget = new Luna_AFL_Widget();
