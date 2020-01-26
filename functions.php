<?php
//Support
add_filter('login_errors',create_function('$a', "return null;"));
remove_action('wp_head', 'wp_generator');
add_theme_support( 'title-tag' );
add_theme_support('post-thumbnails');
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
add_theme_support( 'menus' );
global $user_ID; 
if($user_ID) {
  if(!current_user_can('level_10')) {
    if (strlen($_SERVER['REQUEST_URI']) > 255 ||
      strpos($_SERVER['REQUEST_URI'], "eval(") ||
      strpos($_SERVER['REQUEST_URI'], "CONCAT") ||
      strpos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
      strpos($_SERVER['REQUEST_URI'], "base64")) {
        @header("HTTP/1.1 414 Request-URI Too Long");
	@header("Status: 414 Request-URI Too Long");
	@header("Connection: Close");
	@exit;
    }
  }
}
add_action( 'wp_enqueue_scripts', 'load_scripts');
function load_scripts()
{   wp_deregister_script('jquery');
    wp_enqueue_script('jquery.min', get_template_directory_uri() .'/script/jquery.js','','',true);
    wp_enqueue_script('bootjs', get_template_directory_uri() .'/script/bootstrap.min.js',array('jquery.min'),'',true);
    wp_enqueue_script('menu', get_template_directory_uri() .'/script/mega-menu.js',array('jquery.min'),'',true);
    wp_enqueue_script('fancybox', get_template_directory_uri() .'/script/fancybox.pack.js',array('jquery.min'),'',true);
    wp_enqueue_script('isotope', get_template_directory_uri() .'/script/isotope.min.js',array('jquery.min'),'',true);
    wp_enqueue_script('counter', get_template_directory_uri() .'/script/jquery.countdown.min.js',array('jquery.min'),'',true);
    wp_enqueue_script('slider', get_template_directory_uri() .'/script/jquery.bxslider.js',array('jquery.min'),'',true);
    wp_enqueue_script('functions', get_template_directory_uri() .'/script/functions.js',array('jquery.min'),'',true);
    wp_enqueue_style('bootcss', get_template_directory_uri() .'/css/bootstrap.css');
    wp_enqueue_style('color', get_template_directory_uri() .'/css/color.css');
    wp_enqueue_style('slidercss', get_template_directory_uri() .'/css/jquery.bxslider.css');
    wp_enqueue_style('style', get_template_directory_uri() .'/style.css');
    wp_enqueue_style('fancycss', get_template_directory_uri() .'/css/fancybox.css');
    /*wp_enqueue_style('flaticon', get_template_directory_uri() .'/css/flaticon.css');*/
    wp_enqueue_style('fontAwesome', get_template_directory_uri() .'/css/font-awesome.css');
    wp_enqueue_style('menucss', get_template_directory_uri() .'/css/mega-menu-min.css');
    wp_enqueue_style('responsible', get_template_directory_uri() .'/css/responsive.css');
}
register_nav_menus(array('main'    => 'Основное меню',));
add_action('init','type_project');
function type_project(){
    $labels = array(
        'name' => 'Проект',
        'singular_name' => 'Проекты',
        'add_new' => 'Добавить новый',
        'add_new_item' => 'Добавить новый проект',
        'edit_item' => 'Редактировать проект',
        'new_item' => 'Новый проект',
        'view_item' => 'Посмотреть проект',
        'search_items' => 'Найти проект',
        'not_found' =>  'Проект не найден',
        'not_found_in_trash' => 'В корзине проект не найден',
        'parent_item_colon' => '',
        'menu_name' => 'Проекты'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'thumbnail','custom-fields','excerpt','editor'),

    );
    register_post_type('project', $args);
}
add_action( 'widgets_init', 'register_my_widgets' );
function register_my_widgets(){
    register_sidebar( array(
        'name'          => "Сайдбар для блога",
        'id'            => "blog",
        'before_widget' => '<div class="ezfolio-rich-editor">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => "Сайдбар для портфолио",
        'id'            => "portfolios",
        'before_widget' => '<div class="ezfolio-rich-editor">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
}

/**
 * Шорткоде для вывода услуг
 *
 * Формат: [service show] Заголовок [/service]
 **/
add_shortcode('service','get_service');
function get_service($attr,$content)
{
        $ser = get_option('service-options');
        $html = '<div class="ezfolio-fancy-title"><h2>' . $content . '</h2></div>';
        $html .= '<div class="ezfolio-about-services">';
        for ($i = 1; $i <= 4; $i++){
            if ($i % 2 == 1) $html .= '<div class="row">';
            $html .= '<div class="col-md-6 no-padding"><img src="' . $ser['image' . $i] . '" class="icon-svg" /><h5>' . $ser['title' . $i] . '</h5>' . $ser['text' . $i] . '</div>';
            if ($i % 2 == 0) $html .= '</div>';}
        $html .= '</div>';
        return $html;
}
/**
* Акшен для постов блога, показывает последние 3 записи
**/
add_action('get_related_posts','get_related_posts');
function get_related_posts(){
    $html='';
    $posts=new WP_Query(array('showposts'=>3,'order'=>'date','orderby'=>'DESC','post_type'=>'project'));
    if($posts->have_posts()){
        $html='<div class="ezfolio-section-heading"><h2>Последние работы</h2></div><div class="ezfolio-related-portfolio"><ul class="row">';
        while($posts->have_posts()){
            $posts->the_post();
            $html.='<li class="col-md-4 col-sm-4 col-xs-12 no-padding"><figure><a href="'.get_the_permalink().'"><img src="'.get_the_post_thumbnail_url(get_the_ID(),'thumbnail').'" alt="'.get_the_title().'"></a></figure><section><h5><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5><span>'.get_post_meta(get_the_ID(),'type',true).'</span></section></li>';
        }
        $html.='</ul></div>';
    }
    echo $html;
}
function wp_corenavi() {
    global $wp_query, $wp_rewrite;
    $pages = '';
    $max = $wp_query->max_num_pages;
    if (!$current = get_query_var('paged')) $current = 1;
    $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
    $a['total'] = $max;
    $a['current'] = $current;
    $a['type' ]='list';
    $total = 1;
    $a['mid_size'] = 5;
    $a['end_size'] = 1;
    $a['prev_text'] = '<span aria-label="Next"><i class="fa fa-angle-left"></i></span>';
    $a['next_text'] = '<span aria-label="Next"><i class="fa fa-angle-right"></i></span>';
    if ($max > 1) echo '';
    if ($total == 1 && $max > 1) $pages = ''."\r\n";
    echo $pages . paginate_links($a);
    if ($max > 1) echo '';
}
/**
 * Для вывода самых новых постов на странице конкретной записи
**/
add_action('get_last_posts','get_last_posts');
function get_last_posts(){
    $html='<div class="ezfolio-section-heading"><h2>Другие записи в блоге</h2></div><div class="ezfolio-related-blog"><div class="row">';
    $latest=new WP_Query(array('post_type'=>'post','order'=>'date','orderby'=>'DESC','showposts'=>3));
    while($latest->have_posts()){
        $latest->the_post();
        $html.=' <div class="col-md-4 no-padding">
                                    <figure><a href="'.get_the_permalink().'"><img src="'.get_the_post_thumbnail_url(get_the_ID(),'thumbnail').'" alt="'.get_the_title().'">
                                            <i class="fa fa-link"></i></a></figure>
                                    <div class="ezfolio-related-blog-text">
                                        <h5><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>
                                        <time datetime="2016-07-14 20:00"><i class="fa fa-calendar"></i>'.get_the_date('j F Y',get_the_ID()).'</time>
                                    </div>
                                </div>';
    }
    $html.='</div></div>';
    echo $html;
}
add_shortcode('contact','get_contacts');
function get_contacts($attr,$content){
    $option=get_option('tools-options');
    $html='<div class="ezfolio-fancy-title"><span></span><h2>'.$content.'</h2></div><div class="ezfolio-contact-info"><ul>';
    $phone=$option['social3'];
    $email=$option['social'];
    $html.='<li><h4>E-mail & Телефон</h4><span>'.$email.'</span><span>'.$phone.'</span></li>';
    $html.='</ul></div>';
    return $html;
}
require get_template_directory() . '/inc/options.php';
add_shortcode('team','get_team');
function get_team($attr,$content){
    $html='<div class="ezfolio-main-section"><div class="row"><div class="col-md-12 no-padding"><div class="ezfolio-fancy-title"><span>С кем работаю</span><h2>'.$content.'</h2></div><div class="ezfolio-team ezfolio-team-grid"><ul class="row">' ;
    global $wpdb;
    $workers=$wpdb->get_results("SELECT * FROM `workers_with_me`");
    $i=0;
    foreach($workers as $worker){
        $i++;
        if($i%2==1){
            $class='';
        }
        else{
            $class='right-align';
        }
        $html.='<li class="col-md-12 '.$class.'"><figure><a href="#"><img src="'.$worker->images.'" alt="'.$worker->name.'"></a></figure><div class="ezfolio-team-grid-text"><span>'.$worker->status.'</span><h4>'.$worker->name.'</h4>'.do_shortcode($worker->description).'</div></li>';
    }
    $html.='</ul></div></div></div></div>';
    return $html;
}
add_shortcode('info','get_information');
function get_information($attr,$content){
    $html='<p>'.$content.'</p>';
    if($attr['twitter']!=false|$attr['facebook']!=false|$attr['google']!=false|$attr['instagram']!=false){
        $html.='<ul class="ezfolio-team-social">';
        if($attr['twitter']){
            $html.='<li><a href="'.$attr['twitter'].'" class="fa fa-twitter"></a></li>';
        }
        if($attr['facebook']){
            $html.='<li><a href="'.$attr['facebook'].'" class="fa fa-facebook-official"></a></li>';
        }
        if($attr['google']){
            $html.='<li><a href="'.$attr['google'].'" class="fa fa-glide-g"></a></li>';
        }
        if($attr['instagram']){
            $html.='<li><a href="'.$attr['instagram'].'" class="fa fa-instagram"></a></li>';
        }
        $html.='</ul>';
    }
    return $html;
}
add_shortcode('slide','slide_caption');
function slide_caption($attr,$content){
    $html='';
    if($attr['main']){
        $html.='<h1>'.$content.'</h1>';
    }
    else{
        $html.='<h2>'.$content.'</h2>';
    }
    $html.='<p>'.$attr['description'].'</p><a href="'.$attr['url'].'" class="ezfolio-explore-album">'.$attr['text_url'].'<span class="left-shape"></span><span class="top-right-shape"></span><span class="bottom-right-shape"></span></a>';
    return $html;
}
add_shortcode('title','title_page');
function title_page($attr,$content){
    $html='<div class="ezfolio-fancy-title"><h2>'.$attr['title'].'</h2><p>'.$content.'</p></div>';
    return $html;
}
remove_shortcode('gallery');
add_shortcode('gallery','gallery_pro');
function gallery_pro($attr,$content){
    $option=get_option('main-options');
    $title=$option['name'];
    $html='<div class="ezfolio-main-section"><div class="row"><div class="ezfolio-fancy-title false">'.$content.'</div>';
    $ids=explode(',',$attr['ids']);
    $html.='<div class="ezfolio-gallery ezfolio-modern-gallery ezfolio-filter-gallery"><ul class="row">';
    foreach ($ids as $id){
        $image=wp_get_attachment_image_src($id,'full');
        $description=wp_get_attachment_caption( $id );
        $html.='<li class="col-md-6 element-item nature fashion"><figure><a data-fancybox-group="group" href="'. $image[0].'" class="fancybox"><img src="'. $image[0].'" alt=""></a><span>'.$title.'<small></small></span><figcaption><h5>'.$description.'</h5></figcaption></figure></li>';
    }
    $html.='</ul></div></div></div>';
    return $html;
}