<?php $tc = TextCleaner::getInstance(); ?><li data-id="<?php echo isset($id) ? $id : ''; ?>">

    <div>
        <span class="title"><?php echo $m['title']; ?></span> <i class="fa fa-chevron-down menu_opt_display" title="<?php _e('Show options', 'xthemes'); ?>"></i> <i class="fa fa-trash-o menu_delete" title="<?php _e('Delete item', 'xthemes'); ?>"></i>
        <div class="options row" style="display: none;">
            <div class="xt-separator"></div>
            <div class="option col-md-5">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label><?php _e('Title:', 'xthemes'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input class="form-control" type="text" name="title" value="<?php echo $tc->specialchars($m['title']); ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label><?php _e('URL:', 'xthemes'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input class="form-control" type="text" name="url" value="<?php echo $m['url']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label><?php _e('Rel:', 'xthemes'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input class="form-control" type="text" name="rel" value="<?php echo $m['rel']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label><?php _e('Target:', 'xthemes'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input class="form-control" type="text" name="target" value="<?php echo $m['target']; ?>" />
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <label><?php _e('Extra:', 'xthemes'); ?></label>
                    <input class="form-control" type="text" name="extra" value="<?php echo $m['extra']; ?>" />
                </div>
                <div class="form-group">
                    <label><?php _e('Description:', 'xthemes'); ?></label>
                    <textarea class="form-control" rows="5" cols="45" name="description" placeholder="<?php _e('255 characters long', 'xthemes'); ?>"><?php echo htmlspecialchars($m['description']); ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <?php if ($m['submenu']): ?>
    <ol>
        <?php isset($xtFunctions) ? $xtFunctions->formAdminMenu($m['submenu']) : $this->formAdminMenu($m['submenu']); ?>
    </ol>
    <?php endif; ?>
</li>