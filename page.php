<?php get_header();?>
<div class="ezfolio-main-wrapper"><?php while(have_posts()):?><?php the_post();?>
    <div class="ezfolio-section-left"  style="background-image:url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full');?>);">
        <span class="ezfolio-transparent"></span><?php get_template_part('logo');?>
        <div class="ezfolio-subheader">
            <div class="ezfolio-subheader-heading">
                <h1><?php the_title();?></h1>
                <span><?php echo get_post_meta(get_the_ID(),'description',true);?></span>
            </div>
        </div>
    </div>
    <div class="ezfolio-section-right">
        <div class="ezfolio-main-content">
            <div class="ezfolio-main-section">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ezfolio-breadcrumb">
                            <ul>
                                <li><a href="/">Главная</a></li>
                                <li><?php the_title();?></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <?php the_content();?>
                    </div>
                </div>
            </div>
        </div>
    </div><?php endwhile ?><div class="clearfix"></div>
</div>
<?php get_footer();?>