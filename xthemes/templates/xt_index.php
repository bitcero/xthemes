<h1 class="cu-section-title"><?php _e('Dashboard', 'xthemes'); ?></h1>
<div class="row" data-news="load" data-boxes="load" data-module="xthemes" data-target="#xt-news">

    <div class="col-md-7" data-box="xthemes-box-left">

        <div class="cu-box themes">
            <div class="box-header">
                <h3><?php _e('Recent Themes on Xoops Mexico','xthemes'); ?></h3>
            </div>
            <div class="box-content" id="recent-themes">
&nbsp;
            </div>
            <div class="box-footer foot"><a href="http://www.xoopsmexico.net/downloads/category/temas/" target="_blank"><?php _e('View more themes','xthemes'); ?></a></div>
        </div>

        <div class="cu-box" data-load="news" data-module="xthemes" data-target="#xt-news">
            <div class="box-header">
                <span class="fa fa-caret-up box-handler"></span>
                <h3><?php _e('xThemes Related News','xthemes'); ?></h3>
            </div>
            <div class="box-content" id="xt-news">

            </div>
        </div>
    </div>

    <div class="col-md-5" data-box="xthemes-box-right">

        <div data-load="boxes"></div>

    </div>

</div>

