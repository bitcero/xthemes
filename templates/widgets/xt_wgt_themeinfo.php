<div class="w_screenshot">
    <?php if($theme->getInfo('screenshot')!=''): ?>
    <a href="themes.php"><img src="<?php echo $theme->url().'/'.$theme->getInfo('screenshot'); ?>" alt="<?php echo $theme->getInfo('name'); ?>" /></a>
    <?php endif; ?>
</div>
<h5><?php echo $theme->getInfo('name'); ?></h5>
<div class="w_data">
    <ul>
        <li><?php echo sprintf(__('By %s','xthemes'), '<a href="'.($theme->getInfo('author_uri')!='' ? $theme->getInfo('author_uri') : '#').'" target="_blank">'.$theme->getInfo('author').'</a>'); ?></li>
        <li><?php echo sprintf(__('Version %s','xthemes'), $theme->getInfo('version')); ?></li>
    </ul>
</div>
