<h1 class="cu-section-title"><?php _e('Current Theme', 'xthemes'); ?></h1>
<div class="cu-box">

    <div class="box-content">
        <div class="xt_current">
            <?php if ($current): ?>

                <div class="row">

                    <div class="col-sm-4 col-md-4 xt_current_screenshot">
                        <img src="<?php echo $current->url().'/'.$current->getInfo('screenshot'); ?>" alt="<?php echo $current->getInfo('name'); ?>" class="img-thumbnail">
                    </div>

                    <div class="col-sm-8 col-md-8 xt_current_data">

                        <span class="current_legend"><?php _e('Current Theme', 'xthemes'); ?></span>
                        <h2><?php echo $current->getInfo('name'); ?></h2>

                        <?php if ($current->getInfo('type')=='standard'): ?>
                            <div class="current_standar_legend">
                                <?php _e('This is a standard XOOPS Theme and doesn\'t have any additional options.', 'xthemes'); ?>
                            </div>
                            <a href="<?php echo XOOPS_URL; ?>" class="button" target="_blank"><i class="icon-home"></i> <?php _e('View Site', 'xthemes'); ?></a>
                        <?php else: ?>

                            <div class="row">

                                <?php if ($current->getInfo('author_email') != ''): ?>
                                    <div class="col-xs-3 col-lg-2">
                                        <img src="http://www.gravatar.com/avatar/<?php echo md5($current->getInfo('author_email')); ?>?s=200" class="img-responsive img-thumbnail">
                                    </div>
                                <?php endif; ?>

                                    <div class="<?php echo $current->getInfo('author_email') != '' ? 'col-xs-9 col-lg-10' : 'col-xs-12'; ?>">

                                        <div class="current_data">


                                            <ul>
                                                <li>
                                                    <?php if ($current->getInfo('author_uri')!=''): ?>
                                                        <?php echo sprintf(__('By %s', 'xthemes'), '<a href="'.$current->getInfo('author_uri').'" target="_blank">'.$current->getInfo('author').'</a>'); ?>
                                                    <?php else: ?>
                                                        <?php echo sprintf(__('By %s', 'xthemes'), $current->getInfo('author')); ?>
                                                    <?php endif; ?>
                                                </li>
                                                <li>
                                                    <?php echo sprintf(__('Version %s', 'xthemes'), $current->getInfo('version')); ?>
                                                </li>
                                                <?php if ($current->getInfo('uri')!=''): ?>
                                                    <li><a href="<?php echo $current->getInfo('uri'); ?>" target="_blank"><?php _e('Website', 'xthemes'); ?></a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <div class="current_social">
                                            <?php if ($current->getInfo('social')): ?>
                                                <ul class="nav nav-pills">
                                                    <?php foreach ($current->getInfo('social') as $id => $link): ?>
                                                        <li>
                                                            <a href="<?php echo $link; ?>" target="_blank">
                                                                <?php echo $xtFunctions->social_icon($id); ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                        <div class="current_description">
                                            <p><?php echo $current->getInfo('description'); ?></p>
                                        </div>

                                    </div>

                            </div>

                            <div class="current_options">
                                <h4><span><?php _e('Theme Options', 'xthemes'); ?></span></h4>
                                <ul class="nav nav-pills">
                                    <?php if (method_exists($current, 'controlPanel')): ?>
                                        <li><a href="theme.php" title="<?php _e('Dashboard', 'xthemes'); ?>"><span class="fa fa-dashboard"></span></a></li>
                                    <?php endif; ?>
                                    <?php if ($xtAssembler->rootMenus()): ?>
                                        <li>
                                            <a href="navigation.php" title="<?php _e('Menus', 'xthemes'); ?>">
                                                <?php echo $common->icons()->getIcon('svg-rmcommon-menu'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($current->settings()): ?>
                                        <li>
                                            <a href="settings.php" title="<?php _e('Settings', 'xthemes'); ?>">
                                                <?php echo $common->icons()->getIcon('svg-rmcommon-wrench'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($current->getInfo('uri')!=''): ?>
                                        <li>
                                            <a href="<?php echo $current->getInfo('uri'); ?>" target="_blank" title="<?php _e('Website', 'xthemes'); ?>">
                                                <?php echo $common->icons()->getIcon('svg-rmcommon-home'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($current->getInfo('author_uri')!=''): ?>
                                        <li>
                                            <a href="<?php echo $current->getInfo('author_uri'); ?>" target="_blank" title="<?php _e('Author', 'xthemes'); ?>">
                                                <?php echo $common->icons()->getIcon('svg-rmcommon-user'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="settings.php?action=export&theme=current" id="export-settings" class="text-purple" title="<?php _e('Export settings', 'xthemes'); ?>">
                                            <?php echo $common->icons()->getIcon('svg-rmcommon-export'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="settings.php?action=import&theme=current" id="export-settings" class="text-light-green" title="<?php _e('Import settings', 'xthemes'); ?>">
                                            <?php echo $common->icons()->getIcon('svg-rmcommon-import'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        <?php endif; ?>
                    </div>

                </div>

            <?php endif; ?>
        </div>
    </div>

</div>

<div class="xt_available">
    <h3 class="page-header">Other available themes</h3>

    <div id="themes-items">
        <?php foreach ($themes as $theme): ?>
            <?php if ($theme['dir'] != $current->getInfo('dir')): ?>
                <div class="available-theme">
                    <div class="cu-box" id="available-<?php echo $theme['dir']; ?>">
                        <div class="box-content">
                            <div class="theme_screenshot">
                                <img class="img-responsive img-thumbnail" src="<?php echo $theme['url'].'/'.$theme['screenshot']; ?>" alt="<?php echo $theme['name']; ?>">
                            </div>
                            <div class="available-details">
                                <h3><?php echo $theme['name']; ?></h3>
                                <?php if (isset($theme['type']) && $theme['type']=='standard'): ?>
                                    <span class="help-block"><?php echo _e('This is a standard XOOPS theme.', 'xthemes'); ?></span>
                                <?php else: ?>
                                    <div class="theme-author">
                                        <?php echo sprintf(__('By %s', 'xthemes'), '<a href="'.$theme['author_uri'].'" target="_blank">'.$theme['author'].'</a>'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="box-footer theme-options">

                            <?php if (isset($theme['type']) && $theme['type']=='standard'): ?>
                                <ul class="nav nav-pills nav-justified">
                                    <li><a href="themes.php?action=activate&amp;dir=<?php echo $theme['dir']; ?>&amp;token=<?php echo $xoopsSecurity->createToken(); ?>"><?php _e('Activate', 'xthemes'); ?></a></li>
                                </ul>
                            <?php else: ?>
                                <ul class="nav nav-pills nav-justified">
                                    <?php if (!$theme['installed']): ?>
                                        <li><a href="themes.php?action=install&amp;dir=<?php echo $theme['dir']; ?>&amp;token=<?php echo $xoopsSecurity->createToken(); ?>"><?php _e('Install', 'xthemes'); ?></a></li>
                                    <?php else: ?>
                                        <li><a href="themes.php?action=activate&amp;dir=<?php echo $theme['dir']; ?>"><?php _e('Activate', 'xthemes'); ?></a></li>
                                        <li><a href="themes.php?action=uninstall&amp;dir=<?php echo $theme['dir']; ?>"><?php _e('Uninstall', 'xthemes'); ?></a></li>
                                    <?php endif; ?>
                                    <li><a href="#" class="theme-adetails"><?php _e('Details', 'xthemes'); ?></a></li>
                                </ul>
                            <?php endif; ?>

                            <div class="theme-details" id="details-<?php echo $theme['dir']; ?>">
                <span class="theme_description">
                    <?php echo $theme['description']; ?>
                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</div>
<div id="xt-previewer-blocker"></div>
<div id="xt-previewer">
    <div class="title"><span></span><span class="close">&times;</span></div>
    <div class="website"></div>
</div>

