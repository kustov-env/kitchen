<?php get_header();?>
    <div class="ezfolio-main-wrapper">
            <div class="ezfolio-section-left"  style="background-image:url();">
                <span class="ezfolio-transparent"></span><?php get_template_part('logo');?>
                <div class="ezfolio-subheader">
                    <div class="ezfolio-subheader-heading">
                        <h1>Страница не найдена</h1>
                        <span>Извините,что-то пошло не так!!!</span>
                    </div>
                </div>
            </div>
            <div class="ezfolio-section-right">
            <div class="ezfolio-main-content">
                <div class="ezfolio-main-section">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ezfolio-rich-editor">
                                <div class="cont">
                                    <span class="error">Ошибка</span>
                                    <p class="large">404</p>
                                    <p><strong>Вы попали на несуществующую страницу!</strong></p>
                                    <a href="/" class="ezfolio-readmore-btn">
                                        Вернуться на главную
                                        <span class="btn-right-shape"></span>
                                        <span class="btn-leftbottom-shape"></span>
                                        <span class="btn-rightbottom-shape"></span>
                                    </a>
                                </div>
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