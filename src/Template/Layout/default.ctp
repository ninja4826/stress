

<?php
use Cake\Core\Configure;
?>

<?php if (Configure::read('debug')): ?>
    <?php $this->start('no-cache'); ?>
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
    <?php $this->end(); ?>
<?php else: ?>
    <?php $this->assign('no-cache', ''); ?>
<?php endif; ?>

<?php
if (!$this->fetch('html')) {
    $this->start('html');
    printf('<html lang="%s">', Configure::read('App.language'));
    $this->end();
}

if (!$this->fetch('title') && Configure::read('App.title')) {
    $this->start('title');
    echo Configure::read('App.title');
    $this->end();
}
// Always append App.title to current page title
elseif ($this->fetch('title') && Configure::read('App.title')) {
    $this->append('title', sprintf(' | %s', Configure::read('App.title')));
}

// Prepend some meta tags
$this->prepend('meta', $this->Html->meta('icon', 'favicon.ico?v=2'));
$this->prepend('meta', $this->Html->meta('viewport', 'width=device-width, initial-scale=1'));
$this->prepend('meta', $this->fetch('no-cache'));
if (Configure::read('App.author')) {
    $this->prepend('meta', $this->Html->meta('author', null, [
        'name'    => 'author',
        'content' => Configure::read('App.author')
    ]));
}

// Prepend scripts required by the navbar
$this->prepend('script', $this->Html->script([
    'jquery-2.1.1.min.js',
    'jquery-ui.min',
    'bootstrap.min',
    'typeahead.bundle.min'
]));
$this->prepend('css', $this->Html->css([
    'styles',
    // 'global_utils',
]));

?>
<!--<!DOCTYPE html>-->
<?= $this->fetch('html'); ?>
<head>
    <?= $this->Html->charset(); ?>
    <title>
        <?= $this->fetch('title'); ?>
    </title>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <?php
        // Meta
        echo $this->fetch('meta');

        // // Styles
        // echo $this->Less->less([
        //     'Bootstrap.less/bootstrap.less'
        //     // 'Bootstrap.less/cakephp/styles.less'
        // ]);
        echo $this->fetch('css');

        // Sometimes we'll want to send scripts to the top (rarely..)
        echo $this->fetch('script');
        // echo $this->Html->script('jquery-1.11.2.min');
    ?>
</head>
<body>
    <script>
        var funcs = {
            substringMatcher: function( strs ) {
                return function findMatches(q, cb) {
                    var matches, substrRegex;
                    
                    matches = [];
                    
                    substrRegex = new RegExp(q, 'i');
                    
                    $.each(strs, function(i, str) {
                        if (substrRegex.test(str)) {
                            matches.push({ value: str });
                        }
                    });
                    
                    cb(matches);
                };
            }
        };
        for (var f in funcs) {
            window[f] = funcs[f];
        }
    </script>
    <header role="banner" class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button data-target="#navbar-top" data-toggle="collapse" type="button" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?= $this->Html->link(Configure::read('App.name'), '/', ['class' => 'navbar-brand']); ?>
            </div>
            <nav role="navigation" class="collapse navbar-collapse" id="navbar-top">
                <ul class="nav navbar-nav">
                    <?php $controllers_arr = ['Parts', 'Categories', 'Manufacturers', 'CostCenters']; ?>
                    <?php foreach($controllers_arr as $controller): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= $controller ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><?= $this->Html->link(__('List ' . $controller), ['controller' => 'Modular', 'action' => 'index', $controller]) ?></li>
                                <li><?= $this->Html->link(__('Add ' . $controller), ['controller' => 'Modular', 'action' => 'add', $controller]) ?></li>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <!--<a class="btn btn-default navbar-btn pull-right" href="/search"><span class="glyphicon glyphicon-search"></span> Search</a>-->
            </nav>
        </div>
    </header>
    <div class="container">
        <div id="content" class="row">
            <?= $this->Flash->render(); ?>
            <?= $this->fetch('content'); ?>
        </div>
    </div>
    <script>
        // All 'on document ready' functions for opt-in functionality goes below
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
</head>
</html>