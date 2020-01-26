<?php
/*
Template Name: Шаблон архива проектов
*/
get_header();?>
    <div class="ezfolio-main-wrapper">
        <?php $option=get_option('main-options');?>
        <div class="ezfolio-section-left" style="background-image:url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full');?>);">
            <span class="ezfolio-transparent"></span>
            <?php get_template_part('logo');?>
            <div class="ezfolio-subheader">
                <div class="ezfolio-subheader-heading">
                    <h1><?php the_title()?></h1>
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
                                    <li>Портфолио</li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                            <?php query_posts(array('post_type'=>'project','posts_per_page'=>$option['count_per_project'],'order'=>'date','orderby'=>'DESC','paged'=>(get_query_var('page')) ? get_query_var('page') : 1));?>
                            <?php if(have_posts()):?>
                                <div class="ezfolio-portfolio ezfolio-portfolio-list">
                                <ul class="row">
                                    <?php while(have_posts()):?>
                                        <?php the_post();?>
                                        <li class="col-md-12">
                                            <figure><a href="<?php the_permalink()?>"><img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'large');?>" alt=""></a></figure>
                                            <div class="ezfolio-portfolio-list-text">
                                                <h4><a href="<?php the_permalink()?>"><?php the_title();?></a></h4>
                                                <span><?php echo get_post_meta(get_the_ID(),'type',true);?></span>
                                                <p><?php the_excerpt();?></p>
                                                <a href="<?php the_permalink()?>" class="ezfolio-readmore-btn">
                                                    Подробнее о проекте
                                                    <span class="btn-right-shape"></span>
                                                    <span class="btn-leftbottom-shape"></span>
                                                    <span class="btn-rightbottom-shape"></span>
                                                </a>
                                            </div>
                                        </li>
                                    <?php endwhile;?>
                                </ul>
                                </div><?php endif;?>
                            <div class="ezfolio-pagination"><?php wp_corenavi() ;?>
                                <?php if(dynamic_sidebar('portfolios')):?><?php endif;?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php get_template_part('contacts');?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>