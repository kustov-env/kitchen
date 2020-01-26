<?php $social=get_option('tools-options');?>
<?php $option=get_option('main-options');?>
<footer id="ezfolio-footer" class="ezfolio-footer-one">
    <div class="ezfolio-copyright">
        <div class="row">
            <div class="col-md-12">
                <p><i class="fa fa-copyright"></i><?php echo date('Y');?>, Все права защищены - <a href="/"><?php echo $option['name']?></a></p>
                <ul class="footer-social">
                    <?php if($social['social5']):?><li><a href="<?php echo $social['social5'];?>" target="_blank">Instagram</a></li><?php endif;?>
                    <?php if($social['social6']):?><li><a href="<?php echo $social['social6'];?>" target="_blank">Facebook</a></li><?php endif;?>
                    <?php if($social['social7']):?><li><a href="<?php echo $social['social7'];?>" target="_blank">Twitter</a></li><?php endif;?>
                </ul>
                <a href="" class="ezfolio-back-top"><span></span><i class="fa fa-angle-up"></i></a>
            </div>
        </div>
    </div>
</footer>