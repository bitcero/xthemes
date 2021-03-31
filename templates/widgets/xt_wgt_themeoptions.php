<ul class="w_options">
<?php if (method_exists($theme, 'controlPanel')): ?>
    <li><a href="theme.php"><span class="fa fa-dashboard"></span> <?php _e('Dashboard', 'xthemes'); ?></a></li>
<?php endif; ?>
<?php if ($xtAssembler->rootMenus()): ?>
    <li><a href="navigation.php"><span class="fa fa-reorder"></span> <?php _e('Menus', 'xthemes'); ?></a></li>
<?php endif; ?>
<?php if ($theme->options()): ?>
    <li><a href="settings.php"><span class="fa fa-cog"></span> <?php _e('Settings', 'xthemes'); ?></a></li>
<?php endif; ?>
<?php if ('' != $theme->getInfo('uri')): ?>
    <li><a href="<?php echo $theme->getInfo('uri'); ?>" target="_blank"><span class="fa fa-globe"></span> <?php _e('Website', 'xthemes'); ?></a></li>
<?php endif; ?>
<?php if ('' != $theme->getInfo('author_uri')): ?>
    <li><a href="<?php echo $theme->getInfo('author_uri'); ?>" target="_blank"><span class="fa fa-user"></span> <?php _e('Author', 'xthemes'); ?></a></li>
<?php endif; ?>
</ul>