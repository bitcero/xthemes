<h1 class="cu-section-title"><?php _e('Dashboard', 'xthemes'); ?></h1>
<div class="row xthemes-dashboard" data-news="load" data-boxes="load" data-module="xthemes" data-target="#xt-news" data-container="dashboard" data-box="xthemes-dashboard">

    <div class="size-1" data-dashboard="item">
        <div class="cu-box box-pink">
            <div class="box-header">
                <h3 class="box-title"><?php _e('Current Theme', 'xthemes'); ?></h3>
            </div>
            <div class="box-content">
                <div class="screenshot" style="background-image: url(<?php echo XOOPS_THEME_URL; ?>/<?php echo $currentTheme->getInfo('dir'); ?>/<?php echo $currentTheme->getInfo('screenshot'); ?>);">
                    <ul>
                        <li>
                            <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/themes.php" title="<?php _e('Manage Themes', 'xthemes'); ?>" rel="tooltip">
                                <span class="fa fa-th-large"></span>
                            </a>
                        </li>
                        <?php if (method_exists($currentTheme, 'controlPanel')): ?>
                            <li>
                                <a rel="tooltip" href="<?php echo XOOPS_URL; ?>/modules/xthemes/theme.php"
                                   title="<?php echo sprintf(__('%s Control Panel', 'xthemes'), $currentTheme->getInfo('name')); ?>">
                                    <span class="fa fa-dashboard"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($xtAssembler->rootMenus()): ?>
                            <li>
                                <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/navigation.php" title="<?php _e('Menu Maker', 'xthemes'); ?>" rel="tooltip">
                                    <span class="fa fa-bars"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($currentTheme->options()): ?>
                            <li>
                                <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/settings.php" title="<?php _E('Theme Settings', 'xthemes'); ?>" rel="tooltip">
                                    <span class="fa fa-wrench"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="theme-info">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><?php _e('Name:', 'xthemes'); ?></td>
                            <td>
                                <?php if ('' != $currentTheme->getInfo('uri')): ?>
                                    <a href="<?php echo $currentTheme->getInfo('uri'); ?>" target="_blank"><strong><?php echo $currentTheme->getInfo('name'); ?></strong></a>
                                <?php else: ?>
                                    <strong><?php echo $currentTheme->getInfo('name'); ?></strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php _e('Author:', 'xthemes'); ?></td>
                            <td>
                                <?php if ('' != $currentTheme->getInfo('author_uri')): ?>
                                <a href="<?php echo $currentTheme->getInfo('author_uri'); ?>" target="_blank"><strong><?php echo $currentTheme->getInfo('author'); ?></strong></a>
                                <?php else: ?>
                                <strong><?php echo $currentTheme->getInfo('author'); ?></strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php _e('Version:', 'xthemes'); ?></td>
                            <td><strong><?php echo $currentTheme->getInfo('version'); ?></strong></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="size-1" data-dashboard="item">
        <div class="cu-box box-green available-themes">
            <div class="box-header">
                <h3 class="box-title"><?php _e('Other available themes', 'xthemes'); ?></h3>
            </div>
            <div class="box-content">
                <ul>
                <?php foreach ($themes as $atheme): ?>
                <li>
                    <?php echo $atheme['name']; ?>
                </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="box-footer text-right">
                <a href="themes.php"><span class="fa fa-caret-right"></span> Manage themes</a>
            </div>
        </div>
    </div>

    <div class="size-1" data-dashboard="item">
        <div class="cu-box" data-load="news" data-module="xthemes" data-target="#xt-news">
            <div class="box-header">
                <span class="fa fa-caret-up box-handler"></span>
                <h3 class="box-title"><?php _e('xThemes Related News', 'xthemes'); ?></h3>
            </div>
            <div class="box-content" id="xt-news">

            </div>
        </div>
    </div>

</div>

