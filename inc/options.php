<?php
add_action( 'wp_ajax_delete_admin', 'wp_ajax_delete_admin' );
    function wp_ajax_delete_admin(){
    global $wpdb;
    $wpdb->delete( 'workers_with_me', array( 'id' =>$_POST['data']) );
    wp_die;
}
add_action( 'admin_enqueue_scripts', 'admin_enqueue' );function admin_enqueue(){ wp_enqueue_script( 'admin_custom_script', get_template_directory_uri() .'/script/jquery.js' );wp_enqueue_script( 'custom_script', get_template_directory_uri() .'/script/admin.js' );}
add_action( 'admin_menu', 'get_page_option' );
add_action('admin_init','get_all_option');
    function get_page_option(){
        add_menu_page( 'Настройки контента сайта','Контент сайта','manage_options','contents.php','get_contents','dashicons-format-image',61 );
        add_submenu_page( 'contents.php', 'Услуги', 'Услуги', 'manage_options', 'service-options','get_services_options' );
        add_submenu_page( 'contents.php', 'Команда', 'Моя команда', 'manage_options', 'team-options','get_team_options' );
        add_submenu_page( 'themes.php', 'Слайдер', 'Слайдер главной страницы', 'manage_options', 'slider-options','get_slider_options' );
        add_submenu_page( 'contents.php', 'Социальные сети', 'Социальные сети', 'manage_options', 'tools-options','get_tools' );
        do_action('create_table_worker');
    }
    function get_services_options(){
        ?>
        <div class="wrap">
            <h2>Услуги</h2>
            <p>Управлять количеством услуг можно на <a href="http://kitchen/wp-admin/admin.php?page=contents.php">странице управления контентом</a>(Максимальное количество 10)</p>
            <form action="options.php" method="post" enctype="multipart/form-data">
                <?php settings_fields( 'service' ); ?>
                <?php do_settings_sections( 'service-options' ); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    function get_team_options(){
        ?>
        <div class="wrap">
    <?php do_action('get_worker');?>
            <form action="options.php" method="post" enctype="multipart/form-data">
                <?php settings_fields( 'team' ); ?>
                <?php do_settings_sections( 'team-options' ); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    function get_slider_options(){
        ?>
        <div class="wrap">
            <h2>Слайдер</h2>
            <p>В формате описания слайда можно использовать, как Html,так и шорткоде:<br><strong>[slide main description="Описание" url="URL" text_url="Название кнопки"] Заголовок (Произвольный текс или html)[/slide]</strong>,для главного слайда и <br><strong>[slide main description="Описание" url="URL" text_url="Название кнопки"],</strong>  для других</p>
            <form action="options.php" method="post" enctype="multipart/form-data">
                <?php settings_fields( 'slider' ); ?>
                <?php do_settings_sections( 'slider-options' ); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    function get_tools(){
        ?>
        <div class="wrap">
            <h2>Аккаунты и ссылки</h2>
            <form action="options.php" method="post">
                <?php settings_fields( 'tool' ); ?>
                <?php do_settings_sections( 'tools-options' ); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    function get_contents()
    {
        ?>
        <div class="wrap">
            <form action="options.php" method="POST" enctype="multipart/form-data">
                <?php
                settings_fields( 'main' );
                do_settings_sections("contents");
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
    function get_all_option(){
        $count=get_option('main-options');
        if($count['count_service']==''|$count['count_service']==false){
            $countServ=4;
        }
        else{
            $countServ=$count['count_service'];
        }
        if(get_option('main-options'))
        register_setting('slider','slider-options','slider_validate');
        register_setting('main','main-options','logo_validate');
        register_setting('tool','tools-options');
        register_setting('service','service-options','service_validate');
        register_setting('team','team-options','team_validate');
        add_settings_section( 'team-option', 'Моя команда', '', 'team-options' );
        add_settings_field( 'team_1', '', 'get_workers', 'team-options', 'team-option' );
        add_settings_section( 'main-option', 'Настройки контента сайта', '', 'contents' );
        add_settings_field( 'logo', 'Логотип', 'get_logo', 'contents', 'main-option' , array('label_for' => 'logo') );
        add_settings_field( 'ico', 'Favicon', 'get_ico', 'contents', 'main-option' , array('label_for' => 'ico') );
        add_settings_field( 'count_per_page', 'Количество записей на странице блога', 'get_count_per_page_blog', 'contents', 'main-option' , array('label_for' => 'count_per_page') );
        add_settings_field( 'count_per_project', 'Количество проектов на странице', 'get_count_per_page_project', 'contents', 'main-option' , array('label_for' => 'count_per_project') );
        add_settings_field( 'name', 'Имя владельца', 'get_name_owner', 'contents', 'main-option' , array('label_for' => 'name') );
        add_settings_field( 'count_service', 'Количество услуг', 'get_count_service', 'contents', 'main-option' , array('label_for' => 'count_service') );
        add_settings_field( 'show_comments', 'Использовать комментарии', 'get_show_comments', 'contents', 'main-option' , array('label_for' => 'show_comments') );
        add_settings_section( 'services', 'Услуги', '', 'service-options' );
        for($i=1;$i<=$countServ;$i++)
        {
            add_settings_field( 'title'.$i, 'Заголовок', 'get_title_service'.$i, 'service-options', 'services',array('label_for' => 'title'.$i) );
            add_settings_field( 'text'.$i, 'Описание', 'get_text_service'.$i, 'service-options', 'services',array('label_for' => 'text'.$i) );
            add_settings_field( 'image'.$i, 'Ссылка на изображение', 'get_image_service'.$i, 'service-options', 'services',array('label_for' => 'image'.$i)  );
        }
        add_settings_section( 'tools', 'Настройки социальных сетей', '', 'tools-options' );
        add_settings_field( 'social', 'Mail.ru', 'get_social', 'tools-options', 'tools' , array('label_for' => 'social') );
        add_settings_field( 'social3', 'Телефон', 'get_social3', 'tools-options', 'tools' , array('label_for' => 'social3') );
        add_settings_field( 'social5', 'Instagram', 'get_social5', 'tools-options', 'tools' , array('label_for' => 'social5') );
        add_settings_field( 'social6', 'Facebook', 'get_social6', 'tools-options', 'tools' , array('label_for' => 'social6') );
        add_settings_field( 'social7', 'Twitter', 'get_social7', 'tools-options', 'tools' , array('label_for' => 'social7') );
        add_settings_field( 'social8', 'vk.com', 'get_social8', 'tools-options', 'tools' , array('label_for' => 'social8') );
        add_settings_section( 'slides', 'Слайды', '', 'slider-options' );
        for($i=1;$i<=5;$i++){
            add_settings_field( 'slide_image'.$i, 'Слайд #'.$i, 'get_slides'.$i, 'slider-options', 'slides' , array('label_for' => 'slide_image'.$i) );
            add_settings_field( 'text_slide'.$i, 'Текст слайда #'.$i, 'get_text_slide'.$i, 'slider-options', 'slides' , array('label_for' => 'text_slide'.$i) );
        }
    }
    function get_workers(){
        ?>
        <h2>Добавить нового сотрудника</h2>
        <table class="table" >
            <style>
                .table{margin-left: -200px;}
            </style>
            <tr><td><input type="text" name="team-options[name]" value="" class="regular-text" placeholder="Фамилия, Имя"></td><td><input type="text" name="team-options[status]" value="" class="regular-text" placeholder="Позиция,должность"></td></tr>
        <tr><td style="width: 33%"><input type="file" name="images">
            <p >Вставьте текст в формате шорткода(если нет необходимости в социальных сетях, то просто не вставляйте их в шорткод):<strong>[info twitter="URL" facebook="URL" google="URL" instagram="URL"]Здесь простой текст-описание или html-разметка[/info]</strong> </p></td><td><?php wp_editor('','team-options[description]',array('textarea_name'=>'team-options[description]')); ?></td></tr>
        </table>
        <?php
    }

    function get_title_service1(){
        $options = get_option('service-options');
        ?>

        <input type="text" name="service-options[title1]" value="<?php echo $options['title1']?$options['title1']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service1(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text1']),'service-options[text1]',array('textarea_name'=>'service-options[text1]'));
    }
    function get_image_service1(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image1]" value="<?php echo $options['image1']?$options['image1']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service2(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title2]" value="<?php echo $options['title2']?$options['title2']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service2(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text2']),'service-options[text2]',array('textarea_name'=>'service-options[text2]'));
    }
    function get_image_service2(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image2]" value="<?php echo $options['image2']?$options['image2']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service3(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title3]" value="<?php echo $options['title3']?$options['title3']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service3(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text3']),'service-options[text3]',array('textarea_name'=>'service-options[text3]'));
    }
    function get_image_service3(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image3]" value="<?php echo $options['image3']?$options['image3']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service4(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title4]" value="<?php echo $options['title4']?$options['title4']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service4(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text4']),'service-options[text4]',array('textarea_name'=>'service-options[text4]'));
    }
    function get_image_service4(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image4]" value="<?php echo $options['image4']?$options['image4']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service5(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title5]" value="<?php echo $options['title5']?$options['title5']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service5(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text5']),'service-options[text5]',array('textarea_name'=>'service-options[text5]'));
    }
    function get_image_service5(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image5]" value="<?php echo $options['image5']?$options['image5']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service6(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title6]" value="<?php echo $options['title6']?$options['title2']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service6(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text6']),'service-options[text6]',array('textarea_name'=>'service-options[text6]'));
    }
    function get_image_service6(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image6]" value="<?php echo $options['image6']?$options['image6']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service7(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title7]" value="<?php echo $options['title7']?$options['title7']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service7(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text7']),'service-options[text7]',array('textarea_name'=>'service-options[text7]'));
    }
    function get_image_service7(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image7]" value="<?php echo $options['image7']?$options['image7']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service8(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title8]" value="<?php echo $options['title8']?$options['title8']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service8(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text8']),'service-options[text8]',array('textarea_name'=>'service-options[text8]'));
    }
    function get_image_service8(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image8]" value="<?php echo $options['image8']?$options['image8']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service9(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title9]" value="<?php echo $options['title9']?$options['title9']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service9(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text9']),'service-options[text9]',array('textarea_name'=>'service-options[text9]'));
    }
    function get_image_service9(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image9]" value="<?php echo $options['image9']?$options['image9']:'';?>" class="regular-text">
        <?php
    }
    function get_title_service10(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[title10]" value="<?php echo $options['title10']?$options['title10']:'';?>" class="regular-text">
        <?php
    }
    function get_text_service10(){
        $options = get_option('service-options');
        wp_editor(esc_attr($options['text10']),'service-options[text10]',array('textarea_name'=>'service-options[text10]'));
    }
    function get_image_service10(){
        $options = get_option('service-options');
        ?>
        <input type="text" name="service-options[image10]" value="<?php echo $options['image10']?$options['image10']:'';?>" class="regular-text">
        <?php
    }

    function get_social(){
        $options = get_option('tools-options');
        ?>
        <input type="text" name="tools-options[social]" value="<?php echo $options['social'];?>" class="regular-text">
        <?php
    }
    function get_social1(){
        $options = get_option('tools-options');
        ?>
        <input type="text" name="tools-options[social1]" value="<?php echo $options['social1']?>" class="regular-text">
        <?php
    }
    function get_social3(){
        $options = get_option('tools-options');
        ?>
        <input type="text" name="tools-options[social3]" value="<?php echo $options['social3'];?>" class="regular-text">
        <?php
    }
    function get_social5(){
        $options = get_option('tools-options');
        ?>
        <input type="text" name="tools-options[social5]" value="<?php echo $options['social5'];?>" class="regular-text">
        <?php
    }
    function get_social6(){
        $options = get_option('tools-options');
        ?>
        <input type="text" name="tools-options[social6]" value="<?php echo $options['social6'];?>" class="regular-text">
        <?php
    }
    function get_social7(){
        $options = get_option('tools-options');
        ?>
        <input type="text" name="tools-options[social7]" value="<?php echo $options['social7'];?>" class="regular-text">
        <?php
    }
    function get_social8(){
        $options = get_option('tools-options');
        ?>
        <input type="text" name="tools-options[social8]" value="<?php echo $options['social8'];?>" class="regular-text">
        <?php
    }

    function get_logo(){
        $options = get_option('main-options');
        ?>
        <input type="file" name="logo">
        <input type="hidden" name="logo"  value="<?php echo $options['logo']?>">
        <?php
        if( !empty($options['logo']) ){
            echo "<p><img src='{$options['logo']}'  width='200'></p>";
        }
    }
    function get_ico(){
    $options = get_option('main-options');
    ?>
    <input type="file" name="ico">
    <input type="hidden" name="ico"  value="<?php echo $options['ico']?>">
    <p>Size: 20x20</p>
    <?php
    if( !empty($options['ico']) ){
        echo "<p><img src='{$options['ico']}'  width='20'></p>";
    }
    }
    function get_count_per_page_blog(){
    $options = get_option('main-options');
    ?>
    <input type="text" name="main-options[count_per_page]" value="<?php echo $options['count_per_page']?$options['count_per_page']:'';?>">
    <?php
}
    function get_name_owner(){
    $options = get_option('main-options');
    ?>
    <input type="text" name="main-options[name]" value="<?php echo $options['name']?$options['name']:'';?>">
    <?php
}
    function get_count_service(){
    $options = get_option('main-options');
    ?>
    <input type="text" name="main-options[count_service]" value="<?php echo $options['count_service']?$options['count_service']:'';?>">
    <?php
}
    function get_count_per_page_project(){
        $options = get_option('main-options');
        ?>
        <input type="text" name="main-options[count_per_project]" value="<?php echo $options['count_per_project']?$options['count_per_project']:'';?>">
        <?php
    }
    function get_show_comments(){
        $options = get_option('main-options');
        ?>
        <input type="checkbox" name="main-options[show_comments]" <?php echo $options['show_comments']?'checked':'';?>>
        <?php
    }

    function get_text_slide1(){
        $options = get_option('slider-options');
        wp_editor(esc_attr($options['text_slide1']),'slider-options[text_slide1]',array('textarea_name'=>'slider-options[text_slide1]'));
    }
    function get_text_slide2(){
        $options = get_option('slider-options');
        wp_editor(esc_attr($options['text_slide2']),'slider-options[text_slide2]',array('textarea_name'=>'slider-options[text_slide2]'));
    }
    function get_text_slide3(){
        $options = get_option('slider-options');
        wp_editor(esc_attr($options['text_slide3']),'slider-options[text_slide3]',array('textarea_name'=>'slider-options[text_slide3]'));
    }
    function get_text_slide4(){
        $options = get_option('slider-options');
        wp_editor(esc_attr($options['text_slide4']),'slider-options[text_slide4]',array('textarea_name'=>'slider-options[text_slide4]'));
    }
    function get_text_slide5(){
        $options = get_option('slider-options');
        wp_editor(esc_attr($options['text_slide5']),'slider-options[text_slide5]',array('textarea_name'=>'slider-options[text_slide5]'));
    }
    function get_slides1(){
        $options = get_option('slider-options');
        ?>
        <input type="file" name="slide1">
        <input type="hidden" name="slide1"  value="<?php echo $options['slide1']?>">
        <?php
        if( !empty($options['slide1']) ){
            echo "<p><img src='{$options['slide1']}'  width='200'></p>";
        }
    }
    function get_slides2(){
        $options = get_option('slider-options');
        ?>
        <input type="file" name="slide2" >
        <input type="hidden" name="slide2"  value="<?php echo $options['slide2']?>">
        <?php
        if( !empty($options['slide2']) ){
            echo "<p><img src='{$options['slide2']}'  width='200'></p>";
        }
    }
    function get_slides3(){
        $options = get_option('slider-options');
        ?>
        <input type="file" name="slide3" >
        <input type="hidden" name="slide3"  value="<?php echo $options['slide3']?>">
        <?php
        if( !empty($options['slide3']) ){
            echo "<p><img src='{$options['slide3']}'  width='200'></p>";
        }
    }
    function get_slides4(){
        $options = get_option('slider-options');
        ?>
        <input type="file" name="slide4" >
        <input type="hidden" name="slide4"  value="<?php echo $options['slide4']?>">
        <?php
        if( !empty($options['slide4']) ){
            echo "<p><img src='{$options['slide2']}'  width='200'></p>";
        }
    }
    function get_slides5(){
        $options = get_option('slider-options');
        ?>
        <input type="file" name="slide5" >
        <input type="hidden" name="slide5"  value="<?php echo $options['slide5']?>">
        <?php
        if( !empty($options['slide5']) ){
            echo "<p><img src='{$options['slide5']}'  width='200'></p>";
        }
    }

    function slider_validate($options){
        $overrides = array('test_form' => false);
        foreach ($_FILES as $key=>$value){
            if( !empty($_FILES[$key]['tmp_name']) ){
                $file = wp_handle_upload( $_FILES[$key], $overrides );
                $options[$key] = $file['url'];
            }elseif(!empty($_POST[$key])){
                $options[$key] = $_POST[$key];
            }
        }
        return $options;
    }

    function logo_validate($options){
    $overrides = array('test_form' => false);
    if($_FILES['logo']['tmp_name']){
        $file = wp_handle_upload( $_FILES['logo'], $overrides );
        $options['logo'] = $file['url'];
    }
    elseif(!empty($_POST['logo'])){
        $options['logo'] = $_POST['logo'];
    }
        if($_FILES['ico']['tmp_name']){
            $file = wp_handle_upload( $_FILES['ico'], $overrides );
            $options['ico'] = $file['url'];
        }
        elseif(!empty($_POST['ico'])){
            $options['ico'] = $_POST['ico'];
        }

    if($_FILES['image_project']['tmp_name']){
        $file = wp_handle_upload( $_FILES['image_project'], $overrides );
        $options['image_project'] = $file['url'];
    }
    elseif(!empty($_POST['image_project'])){
        $options['image_project'] = $_POST['image_project'];
    }
    return $options;
}
    add_action('create_table_worker','create_table');
    function create_table()
{
    global $wpdb;
    $query = 'CREATE TABLE IF NOT EXISTS `workers_with_me` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `images` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `status` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;';
    $wpdb->query($query);
}
    function team_validate($options){
    $overrides = array('test_form' => false);
    $file = wp_handle_upload( $_FILES['images'], $overrides );
    $images= $file['url'];
    global $wpdb;
    $wpdb->insert('workers_with_me',array( 'images' => $images, 'status' => $options['status'],'name'=>$options['name'],'description'=> $options['description']),array( '%s', '%s','%s', '%s' ));
}
add_action('get_worker','get_worker');
function get_worker(){
    global $wpdb;
    $worker=$wpdb->get_results("SELECT * FROM `workers_with_me`");
    if($worker!=false) {
        $html = '<table class="table-get"><thead><tr><th>Фото</th><th>Позиция(должность)</th><th>Фамилия,Имя</th><th>Описание</th><th>Удалить</th></tr></thead><tbody>';
        foreach ($worker as $item) {
            $html .= '<tr><td><img src="' . $item->images . '" width="200" height="200"></td><td>' . $item->status . '</td><td>' . $item->name . '</td><td>' . $item->description . '</td><td><button id="btn"  data-id="' . $item->id . '" >Удалить</button></td></tr>  ';
        }
        $html .= '</tbody></table><style>.table-get th. .table-get td{width: 25%}</style>';
    }
    echo $html;
}