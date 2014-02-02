<h1 class="cu-section-title"><?php _e('Dashboard', 'xthemes'); ?></h1>
<div class="row">

    <div class="col-md-8">

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

    <div class="col-md-4">

        <div class="cu-box">
            <div class="box-header">
                <h3><i class="fa fa-thumbs-up"></i> <?php _e('Support my Work','dtransport'); ?></h3>
            </div>
            <div class="box-content support-me">
                <img class="avatar" src="http://www.gravatar.com/avatar/<?php echo $myEmail; ?>?s=80" alt="Eduardo Cortés (bitcero)" />
                <p><?php _e('Do you like my work? Then maybe you want support me to continue developing new modules.','dtransport'); ?></p>
                <?php echo $donateButton; ?>
            </div>
        </div>

        <div data-load="boxes"></div>

    </div>

</div>

