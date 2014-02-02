<ul class="w_options">
<?php if(method_exists($theme, 'controlPanel')): ?>
    <li><a href="theme.php"><i class="icon-gear"></i> <?php _e('Dashboard','xthemes'); ?></a></li>
<?php endif; ?>
<?php if($xtAssembler->rootMenus()): ?>
    <li><a href="navigation.php"><i class="icon-reorder"></i> <?php _e('Menus','xthemes'); ?></a></li>
<?php endif; ?>
<?php if($theme->options()): ?>
    <li><a href="settings.php"><i class="icon-wrench"></i> <?php _e('Settings','xthemes'); ?></a></li>
<?php endif; ?>
<?php if($theme->getInfo('uri')!=''): ?>
    <li><a href="<?php echo $theme->getInfo('uri'); ?>" target="_blank"><i class="icon-home"></i> <?php _e('Website','xthemes'); ?></a></li>
<?php endif; ?>
<?php if($theme->getInfo('author_uri')!=''): ?>
    <li><a href="<?php echo $theme->getInfo('author_uri'); ?>" target="_blank"><i class="icon-user"></i> <?php _e('Author','xthemes'); ?></a></li>
<?php endif; ?>
</ul>