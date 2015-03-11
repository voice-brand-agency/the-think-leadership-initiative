<?php
class MET_Image_With_Text extends AQ_Block {

    function __construct() {
        $block_options = array(
            'name' => 'Image and Text',
            'size' => 'span6'
        );

        parent::__construct('MET_Image_With_Text', $block_options);
    }

    function form($instance) {

        $defaults = array(
            'title'			=> '',
            'the_image'	    => '',
            'text' 			=> ''
        );
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);

        ?>

        <p class="description">
            <label for="<?php echo $this->get_field_id('title') ?>">
                Title
                <?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
            </label>
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('the_image') ?>">
                Image
                <?php echo aq_field_upload('the_image', $block_id, $the_image) ?>
            </label>
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('text') ?>">
                Content
                <?php echo aq_field_textarea('text', $block_id, $text, $size = 'full met_ckeditor') ?>
            </label>
        </p>

    <?php
    }

    function block($instance) {
        extract($instance);

        if (!empty($the_image)) {
            $boxImage = aq_resize($the_image, 185, 185, true);
            if (!$boxImage) {
                $boxImage = $the_image;
            }
        } else {
            $boxImage = 'http://placehold.it/185x185';
        }

        ?>
        <div class="row-fluid">
            <div class="span12">
                <article class="met_service_box clearfix image_with_text">
                    <img src="<?php echo $boxImage; ?>">
                    <h2 class="met_bold_one spaced"><?php echo $title ?></h2>
                    <?php echo htmlspecialchars_decode($text) ?>
                </article>
            </div>
        </div>
    <?php
    }

}