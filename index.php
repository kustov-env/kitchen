<?php get_header();?>
    <div class="ezfolio-main-wrapper">
        <?php get_template_part('logo');?>
    <div class="ezfolio-banner"><?php $slides=get_option('slider-options');?>
        <ul class="ezfolio-banner-one"><?php if($slides['slide1']!=''|$slides['slide1']!=false):?>
            <li style="background-image:url(<?php echo $slides['slide1'];?>); ">
             <span class="ezfolio-transparent"></span>
                <div class="ezfolio-banner-caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ezfolio-banner-wrap">
                                    <?php echo apply_filters( 'the_content',$slides['text_slide1']);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="slide-number">01</span>
            </li><?php endif;?><?php if($slides['slide2']!=''|$slides['slide2']!=false):?>
            <li style="background-image:url(<?php echo $slides['slide2']?>);">
                <span class="ezfolio-transparent"></span>
                <div class="ezfolio-banner-caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ezfolio-banner-wrap">
                                    <?php echo apply_filters( 'the_content',$slides['text_slide2']);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="slide-number">02</span>
            </li><?php endif;?><?php if($slides['slide3']!=''|$slides['slide3']!=false):?>
            <li style="background-image:url(<?php echo $slides['slide3']?>)">
                <span class="ezfolio-transparent"></span>
                <div class="ezfolio-banner-caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ezfolio-banner-wrap">
                                    <?php echo apply_filters( 'the_content',$slides['text_slide3']);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="slide-number">03</span>
            </li><?php endif;?><?php if($slides['slide4']!=''|$slides['slide4']!=false):?>
                <li style="background-image:url(<?php echo $slides['slide4']?>)">
                    <span class="ezfolio-transparent"></span>
                    <div class="ezfolio-banner-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ezfolio-banner-wrap">
                                        <?php echo apply_filters( 'the_content',$slides['text_slide4']);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="slide-number">04</span>
                </li><?php endif;?><?php if($slides['slide5']!=''|$slides['slide5']!=false):?>
                <li style="background-image:url(<?php echo $slides['slide5']?>)">
                    <span class="ezfolio-transparent"></span>
                    <div class="ezfolio-banner-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ezfolio-banner-wrap">
                                        <?php echo apply_filters( 'the_content',$slides['text_slide5']);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="slide-number">05</span>
                </li><?php endif;?>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
<?php get_footer();?>