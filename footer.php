<?php $option=get_option('main-options');?>
<?php $social=get_option('tools-options');?>
<div class="main-menu mobile-mega-menu ezfolio-navigation">
    <div class="ezfolio-logo-toggle bottom-menu">
        <a href="#" class="close-button main-menu-toggle block"><i class="fa fa-times"></i></a>
        <a href="/" class="ezfolio-logo"><img src="<?php echo $option['logo'];?>" width="300" alt="Алексей Тернов"></a>
    </div>
    <div class="ezfolio-main-navigation">
        <nav>
        <?php wp_nav_menu( array('theme_location'=>'main','container'=> 'ul','menu_class'=>'', 'menu_id'=>'','items_wrap'=>'<ul>%3$s</ul>',));?>
        </nav>
    </div>
    <div class="ezfolio-bottom-strip">
        <div class="ezfolio-right-info">
            <?php if($social['social3']):?><span><i class="fa fa-phone"></i><?php echo $social['social3'];?></span><?php endif;?>
            <?php if($social['social']):?><span><i class="fa fa-envelope"></i><a href="mailto:<?php echo $social['social'];?>">Email: <?php echo $social['social'];?></a></span><?php endif;?>
        </div>
    </div>
</div>
<?php wp_footer();?>
</body>
</html>