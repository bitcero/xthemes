<?php
// $Id: standardtheme.class.php 99 2012-10-24 21:46:58Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

class StandardTheme extends XtTheme implements XtITheme
{
    public function details()
    {
        $details = array(
            'name' => '',
            'description' => 'Theme based on original FastPage template from AtomicWebsiteTemplates.com',
            'version' => '1.0',
            'author' => 'Not provided',
            'uri' => '',
            'author_uri' => '',
            'author_email' => '',
            'license' => 'Not specified',
            'screenshot' => 'screenshot.png',
            'type' => 'standard'
        );
        
        return $details;
    }
    
    public function set_dir($dir)
    {
        $this->details['dir'] = $dir;
        $this->details['name'] = ucfirst($dir);
    }
    
    public function haveMenus()
    {
        return false;
    }
    public function options()
    {
        return false;
    }
    public function init()
    {
    }
}
