<?php get_header();?>
<div class="ezfolio-main-wrapper">
    <?php $option=get_option('main-options');?>
    <?php while(have_posts()):?>
    <?php the_post();?>
    <div class="ezfolio-section-left" style="background-image:url(<?php $image=wp_get_attachment_image_src(get_post_meta(get_the_ID(),'big_image',true),'full'); echo $image[0]?>);">
        <span class="ezfolio-transparent"></span>
        <?php get_template_part('logo');?>
        <div class="ezfolio-subheader">
            <div class="ezfolio-subheader-heading">
                <h1><?php the_title()?></h1>
                <span><?php the_excerpt()?></span>
            </div>
        </div>
    </div>
    <div class="ezfolio-section-right">
        <div class="ezfolio-main-content">
            <div class="ezfolio-main-section">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ezfolio-breadcrumb black">
                            <ul>
                                <li><a href="/">Главная</a></li>
                                <li><a href="<?php echo get_post_type_archive_link('project'); ?>">Портфолио</a></li>
                                <li><?php the_title()?></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <figure class="ezfolio-portfolio-thumb"> <?php the_post_thumbnail('large');?></figure>
                        <div class="ezfolio-section-heading"><h2><?php the_title();?></h2></div>
                        <div class="ezfolio-rich-editor">
                           <?php the_content();?>
                        </div>
                        <div class="ezfolio-rich-editor">
                            <p>Поделиться в социальных сетях:</p>
                            <div id="subscribe_links">
                                <a target="_blank" rel="nofollow" onclick="popupWin = window.open(this.href, 'vkontakte', 'width=550,height=400,top='+((screen.height-400)/2)+',left='+((screen.width-550)/2)+',location=no'); popupWin.focus(); return false;" href="http://vk.com/share.php?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&description=<?php the_excerpt(); ?>&image=<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>&noparse=true"><i class="fa fa-vk"></i></a>
                                <a target="_blank" rel="nofollow" onclick="popupWin = window.open(this.href, 'vkontakte', 'width=550,height=400,top='+((screen.height-400)/2)+',left='+((screen.width-550)/2)+',location=no'); popupWin.focus(); return false;" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
                                <a target="_blank" rel="nofollow" onclick="popupWin = window.open(this.href, 'vkontakte', 'width=550,height=400,top='+((screen.height-400)/2)+',left='+((screen.width-550)/2)+',location=no'); popupWin.focus(); return false;" rel="nofollow" href="https://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>"><i class="fa fa-twitter"></i></a>
                                <a target="_blank" rel="nofollow" onclick="popupWin = window.open(this.href, 'vkontakte', 'width=550,height=400,top='+((screen.height-400)/2)+',left='+((screen.width-550)/2)+',location=no'); popupWin.focus(); return false;" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a>
                            </div>
                        </div>
                        <?php if($option['show_comments']!=false|$option['show_comments']!=''):?>
                        <div class="ezfolio-rich-editor">
                            <?php if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;?>
                            <?php endif;?>
                            <?php if(dynamic_sidebar('portfolios')):?><?php endif;?>
                        <?php do_action('get_related_posts');?>
                    </div>
                </div>
            </div>
        </div>
            <?php get_template_part('contacts');?>
        </div>
    </div>
    <?php endwhile?>
    <div class="clearfix"></div>
</div>
<?php get_footer();?>