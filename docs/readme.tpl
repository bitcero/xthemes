<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>xThemes for Common Utilities</title>
    <link href="http://netdna.bootstrapcdn.com/bootswatch/3.1.1/cosmo/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</head>

<body style="padding-top: 70px;">

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">More &raquo;</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="leeme.html"><span class="fa fa-language"></span> Español</a></li>
                <li><a href="http://www.github.com/bitcero/xthemes/"><span class="fa fa-github-alt"></span> GitHub</a></li>
                <li><a href="http://www.github.com/bitcero/rmcommon/"><span class="fa fa-download"></span> Get Common Utilities</a></li>
                <li><a href="http://www.github.com/bitcero/"><span class="fa fa-asterisk"></span> Other Modules</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Follow me <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="http://eduardocortes.mx"><span class="fa fa-quote-left"></span> My Blog (Spanish)</a></li>
                        <li><a href="http://twitter.com/bitcero/"><span class="fa fa-twitter-square"></span> Twitter</a></li>
                        <li><a href="http://facebook.com/eduardo.cortes.hervis/"><span class="fa fa-facebook-square"></span> Facebook</a></li>
                        <li><a href="http://instagram.com/eduardocortesh/"><span class="fa fa-instagram"></span> Instagram</a></li>
                        <li><a href="http://linedin.com/in/bitcero/"><span class="fa fa-linkedin-square"></span> LinkedIn</a></li>
                        <li class="divider"></li>
                        <li><a href="http://eduardocortes.mx/acerca-de-eduardo-cortes/"><span class="fa fa-user"></span> Eduardo Cortes</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>

<div class="container">

    <header>
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    <img src="https://raw.githubusercontent.com/bitcero/xthemes/master/xthemes/images/logo.png" alt="xThemes logo" width="92" height="52" class="pull-left img-thumbnail" style="margin: 0 10px 0 0;">
                    xThemes for Common Utilities<br>
                    <small><em>for a beautiful XOOPS</em></small>
                </h1>
            </div>
        </div>
    </header>

    <hr>

    <div class="row">

        <article class="col-xs-12 col-md-8">

            <p>¡Thanks for download <strong>xThemes</strong>. xThemes is a themes manager/framework for XOOPS. This means that allow to design
                and develop new themes providing new tools and utilities to achieve better results than ever.</p>
            <hr>
            <h3>What xThemes offers me that XOOPS not?</h3>
            <p>
                The answer is very simple. xThemes gives you all the capabilities of XOOPS and Smarty to create themes, but also adds improvements and new
                exciting posibilities for your themes, making them fundamentally different to others. Do you know XOOPS modules? Well, xThemes locate the
                themes to the same level that a module. Following is a partial list of what themes offers:
            </p>
            <ul>
                <li>A menu maker (forget modules to make menus).</li>
                <li>Configuration like a module.</li>
                <li>Customization trough configuration.</li>
                <li>Plugins for Smarty.</li>
                <li>Theme plugins.</li>
                <li>Fully integration to low level.</li>
                <li>All Common Utilities capabilites.</li>
            </ul>
            <hr>
            <h3>Requirements</h3>
            <ul>
                <li><a href="http://xoops.org/">XOOPS 2.5.x</a> (tested on 2.5.7 version)</li>
                <li><a href="http://www.github.com/bitcero/rmcommon/">Common Utilities 2.2</a></li>
                <li><a href="https://github.com/bitcero/advform">Advanced Forms plugin</a></li>
            </ul>
            <hr>
            <h3>Install</h3>
            <p class="important"><strong>Important: </strong>before installing xThemes, <abbr title="Common Utilities">rmcommon</abbr> must be installed, otherwise the module may not be properly installed.</p>
            <ol>
                <li>Extract the compressed file to your hard disk.</li>
                <li>Upload folder &laquo;<strong><code>xthemes</code></strong>&raquo; to directory &laquo;<code>modules</code>&raquo; in your XOOPS installation.</li>
                <li>Go to XOOPS control panel, then go to the Common Utilities modules manager and install <strong>xThemes</strong>strong> such as normal module.</li>
                <li>Done! xThemes has been installed..</li>
            </ol>
            <hr>
            <h3>Troubleshooting</h3>
            <p>
                Sometimes xThemes doesn't work properly at the first installation. Generally this may ocurr due to a problem with the &laquo;modules active&raquo; file.
                To solve this situation you can folow next steps:
            </p>
            <ol>
                <li>Locate the folder <code>xoops_data/caches/xoops_cache</code>.</li>
                <li>With a text or code editor, open file <code>xoops_(<em>some alphanumeric chars</em>)_system_modules_active.php</code></li>
                <li>You can find several lines. Check if a line containing xthemes already exists. Example:<br>
                    <pre>0 => '<em>module</em>',
1 => '<em>module</em>',
2 => '<em>xthemes</em>',
3 => 'etc...',</pre></li>
                <li>If xthemes is not present, then add a new line continuing the numbering:
                <pre>4 => '<strong>xthemes</strong>',</pre> This line muste be add between existing parenthesis.</li>
            </ol>
            <p>
                Example of a finished file:
            </p>
            <pre>1422009898
return array (
  0 => 'system',
  1 => 'rmcommon',
  2 => 'mywords',
  3 => 'xthemes',
  4 => 'galleries',
  5 => 'vcontrol',
  6 => 'contacts',
  7 => 'contact',
  8 => 'works',
);</pre>
            <hr>
            <h3>Get xThemes</h3>
            <p>You can get the latest version of <strong>xThemes</strong> directly from <a href="http://github.com/bitcero/xthemes/releases/"><span class="fa fa-github-alt"></span> GitHub</a>.</p>
            <p>Also, you can <em>fork</em> the <strong>xThemes</strong> repository from <a href="http://github.com/bitcero/xthemes/"><span class="fa fa-code-fork"></span> GitHub</a>.</p>
            <p class="important"><strong>Notice:</strong>strong> Do not use the deveopment version in sites on production.</p>
            <hr>
            <h3>Bugs report</h3>

            <p>Please use the <a href="https://github.com/bitcero/xthemes/issues"><span class="fa fa-exclamation-circle"></span> issues tool from GitHub</a> to report bugs.
            This is the best way and the only that I check frequently.</p>

            <hr>

        </article>

        <aside class="col-xs-12 col-md-4">

            <div class="alert alert-success">
                <div class="row">
                    <div class="col-xs-3">
                        <a href="http://eduardocortes.mx"><img src="http://www.gravatar.com/avatar/a888698732624c0a1d4da48f1e5c6bb4?s=70" alt="Eduardo Cortés" style="padding: 1px; border: 1px solid rgba(0,0,0,0.3);"></a>
                    </div>
                    <div class="col-xs-9">
                        <h4>Available as Freelance!</h4>
                        <p>You can hire me to develop modules and design themes.</p>
                    </div>
                </div>

            </div>

            <div class="panel panel-warning">
                <div class="panel-heading">
                    I have extensive experience on:
                </div>
                <div class="panel-body" style="text-align: center;">
                    <span class="label label-danger">PHP</span>
                    <span class="label label-danger">HTML5</span>
                    <span class="label label-danger">CSS3</span>
                    <span class="label label-danger">Javascript</span>
                    <span class="label label-danger">jQuery</span>
                    <span class="label label-danger">AJAX</span>
                </div>
                <div class="panel-footer">
                    <strong>Hey! I can create amazing themes for you.</strong>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    Interested on hire me?
                </div>
                <div class="panel-body" style="text-align: center">
                    <a href="http://eduardocortes.mx/acerca-de-eduardo-cortes/" class="btn btn-primary"><span class="fa fa-home"></span> My Web Site</a>
                    <a href="mailto:yo@eduardocortes.mx" class="btn btn-primary"><span class="fa fa-envelope"></span> Email me</a>
                </div>
            </div>

        </aside>


    </div>

</div>


</body>
</html>
