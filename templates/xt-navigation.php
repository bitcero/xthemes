<h1 class="cu-section-title"><?php _e('Menus and Navigation', 'xthemes'); ?></h1>

<p class="help-block">
    <?php echo sprintf(__('This theme have %u different menus that can be configured with xThemes menus.', 'xthemes'), count($menus)); ?>
    <?php _e('To configure menus please select a menu by clicking on tab name, and then use next form to add elements.', 'xthemes'); ?>
</p>

<a href="#" class="btn btn-primary add-menu"><i class="icon-plus-sign"></i> <?php _e('Add Menu', 'xthemes'); ?></a>
<a href="#" class="btn btn-success save-menu"><i class="icon-ok-sign"></i> <?php _e('Save Menu', 'xthemes'); ?></a>
<div class="xt-separator"></div>

<div id="xt-messages" class="xt-msg-error">
    <span></span>
    <span class="icon icon-closeblack close"></span>
</div>

<ul id="menus-select">
<?php $i = 0; ?>
<?php foreach ($menus as $id => $menu): ?>
    <li><a href="#" rel="menu-<?php echo $id; ?>"<?php echo $i==0 ? ' class="selected"': ''; ?>><?php echo $menu['title']; ?></a></li>
    <?php $i++; ?>
<?php endforeach; ?>    
</ul>
<?php $i = 0; ?>
<?php foreach ($menus as $id => $menu): ?>
<div id="menu-<?php echo $id; ?>" class="xt-menus-container<?php echo $i==0 ? ' container-selected': ''; ?>">
    <ol>
        <?php foreach ($theme_menu[$id] as $m): ?>
        <?php include $tpl->path('xt-menu-manager.php', 'module', 'xthemes'); ?>
        <?php endforeach; ?>
    </ol>
    <?php $i++; ?>
</div>
<?php endforeach; ?>

<script type="text/javascript">
<?php foreach ($menus as $id => $menu): ?>
$("#menu-<?php echo $id; ?> ol").nestedSortable({
    handle: 'div',
    items: 'li',
    tolerance: 'pointer',
    toleranceElement: '> div',
    maxLevels: <?php echo $menu['levels']; ?>,
    placeholder: 'placeholder',
    forcePlaceholderSize: true,
});

<?php endforeach; ?>
</script>

<ol id="copy">
    <li>
        <div>
            <span class="title"><?php _e('Menu Item', 'xthemes'); ?></span> <i class="fa fa-chevron-down menu_opt_display displayed" title="<?php _e('Show options', 'xthemes'); ?>"></i> <i class="fa fa-trash-o menu_delete" title="<?php _e('Delete item', 'xthemes'); ?>"></i>
            <div class="options row" style="display: block;">
                <div class="xt-separator"></div>
                <div class="option col-md-5">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label><?php _e('Title:', 'xthemes'); ?></label>
                            </div>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="title" value="<?php _e('Menu Item', 'xthemes'); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label><?php _e('URL:', 'xthemes'); ?></label>
                            </div>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="url" value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label><?php _e('Rel:', 'xthemes'); ?></label>
                            </div>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="rel" value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label><?php _e('Target:', 'xthemes'); ?></label>
                            </div>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="target" value="" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label><?php _e('Extra:', 'xthemes'); ?></label>
                        <input class="form-control" type="text" name="extra" value="" />
                    </div>
                    <div class="form-group">
                        <label><?php _e('Description:', 'xthemes'); ?></label>
                        <textarea class="form-control" rows="5" cols="45" name="description" placeholder="<?php _e('255 characters long', 'xthemes'); ?>"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ol>