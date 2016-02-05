<h1 class="cu-section-title"><?php echo sprintf(__('%s Settings','xthemes'), $xtAssembler->theme()->getInfo("name")); ?></h1>

<form name="formSettings" id="frm-settings" action="settings.php" method="post">
    <ul class="nav nav-tabs xt-settings-tabs cu-top-tabs">
        <?php if(count($sections)<=6): ?>
            <?php foreach($sections as $name => $section): ?>
                <li<?php if($visible==$name): ?> class="active"<?php endif; ?>><a href="#section-<?php echo $name; ?>" data-toggle="tab"><?php echo $section; ?></a></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php _e('Configuration Sections','xthemes'); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php foreach($sections as $name => $section): ?>
                        <li<?php if($visible==$name): ?> class="active"<?php endif; ?>><a href="#section-<?php echo $name; ?>" data-toggle="tab"><?php echo $section; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endif; ?>
        <li class="pull-right"><button type="submit" class="btn btn-info"><?php _e('Save Settings','xthemes'); ?></button></li>
    </ul>

    <div class="tab-content">
        <?php foreach($sections as $name => $section): ?>
            <div id="section-<?php echo $name; ?>" class="tab-pane<?php if($visible==$name): ?> active<?php endif; ?> xt-configuration-section">
                <?php if(isset($options[$name])): ?>
                    <?php foreach($options[$name] as $name => $option): ?>
                        <?php if( isset($option['type']) && $option['type'] == 'heading'): ?>
                            <h3>
                                <?php echo $option['caption']; ?><br>
                                <?php if( isset( $option['description'] ) && $option['description'] != '' ): ?>
                                    <small><?php echo $option['description']; ?></small>
                                <?php endif; ?>
                            </h3>
                            <hr>
                        <?php elseif ( isset($option['type']) && $option['type'] == 'divider'): ?>
                            <hr>
                        <?php else: ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-lg-3">
                                        <label for="<?php echo $name; ?>">
                                            <strong><?php echo $option['caption']; ?></strong>
                                        </label>
                                        <?php if($option['description']!=''): ?>
                                            <span class="help-block"><?php echo $option['description']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-8 col-lg-9">
                                        <?php echo $option['field']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="xt-settings-buttons sb-bottom">
            <div>
                <div class="alert alert-info">
                    <?php _e('You can configure all sections before to press "Save Settings" button. Change between sections will not loose configured data.', 'xthemes'); ?>
                </div>
                <div>
                    <button type="submit" class="btn btn-lg btn-primary"><?php _e('Save Settings','xthemes'); ?></button>
                </div>
            </div>
        </div>

        <?php echo $xoopsSecurity->getTokenHTML(); ?>
        <input type="hidden" name="action" value="save" />
    </div>
</form>