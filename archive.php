<?php
/*
Template Name: Шаблон для вывода постов блога
*/
get_header()?>
<div class="ezfolio-main-wrapper">
<?php $option=get_option('main-options');?>
    <?php while(have_posts()):?><?php the_post();?>
        <div class="ezfolio-section-left" style="background-image:url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full');?>);">
            <span class="ezfolio-transparent"></span>
            <?php get_template_part('logo');?>
            <div class="ezfolio-subheader">
                <div class="ezfolio-subheader-heading">
                    <h1><?php the_title();?></h1>
                    <span><?php echo get_post_meta(get_the_ID(),'description',true);?></span>
                </div>
            </div>
        </div>
    <?php endwhile;?>
    <div class="ezfolio-section-right">
        <div class="ezfolio-main-content">
            <div class="ezfolio-main-section">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ezfolio-breadcrumb">
                            <ul>
                                <li><a href="/">Главная</a></li>
                                <li>Мой блог</li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <?php query_posts(array('posts_per_page'=>$option['count_per_page'],'order'=>'date','orderby'=>'DESC','paged'=>get_query_var('paged') ? get_query_var('paged') : 1));?>
                        <?php if(have_posts()):?>
                        <div class="ezfolio-blog ezfolio-blog-large">
                            <ul class="row">
                                <?php while(have_posts()):?><?php the_post();?>
                                    <li class="col-md-12">
                                        <figure>
                                            <a href="<?php the_permalink();?>"><img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),"large")?>" alt="<?php the_title();?>">
                                                <span class="blog-icon-shape"><i class="fa fa-angle-double-right"></i>
                                                <span class="blog-icon-shape2"></span>
                                                <span class="blog-icon-shape3"></span>
                                                <span class="blog-icon-shape4"></span>
                                                </span>
                                            </a>
                                        </figure>
                                        <div class="ezfolio-blog-large-text">
                                            <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                                            <ul class="ezfolio-blog-option">
                                                <li><i class="fa fa-clock-o"></i> <time datetime="<?php the_time('j F Y')?>"><?php the_time('j F Y')?></time></li>
                                               <?php if($option['show_comments']!=false):?> <li><i class="fa fa-commenting-o"></i> <a href="<?php the_permalink();?>"><?php comments_number('0 комментариев', '1 комменатрий', '% комментариев'); ?></a></li><?php endif;?>
                                            </ul>
                                            <p><?php the_excerpt();?></p>
                                            <a href="<?php the_permalink();?>" class="ezfolio-readmore-btn">
                                                Подробнее
                                                <span class="btn-right-shape"></span>
                                                <span class="btn-leftbottom-shape"></span>
                                                <span class="btn-rightbottom-shape"></span>
                                            </a>
                                        </div>
                                    </li><?php endwhile;?>
                            </ul>
                        </div><?php endif;?>
                        <div class="ezfolio-pagination"><?php wp_corenavi() ;?>
                        <?php if(dynamic_sidebar('blog')):?><?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php get_template_part('contacts');?>
    </div>
</div>
<?php get_footer();?>