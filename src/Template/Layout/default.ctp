<?php
use Cake\Core\Configure;

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
$this->prepend('meta', $this->Html->meta('icon'));
$this->prepend('meta', $this->Html->meta('viewport', 'width=device-width, initial-scale=1'));
if (Configure::read('App.author')) {
    $this->prepend('meta', $this->Html->meta('author', null, [
        'name'    => 'author',
        'content' => Configure::read('App.author')
    ]));
}

// Prepend scripts required by the navbar
$this->prepend('script', $this->Html->script([
    '//code.jquery.com/jquery-2.1.1.min.js',
    '/bootstrap/js/transition',
    '/bootstrap/js/collapse',
    '/bootstrap/js/dropdown',
    '/bootstrap/js/alert'
]));

?>
<!DOCTYPE html>
<?= $this->fetch('html'); ?>
<head>
    <?= $this->Html->charset(); ?>
    <title>
        <?= $this->fetch('title'); ?>
    </title>
    <?php
        // Meta
        echo $this->fetch('meta');

        // Styles
        echo $this->Less->less([
            'Bootstrap.less/bootstrap.less'
            // 'Bootstrap.less/cakephp/styles.less'
        ]);
        echo $this->fetch('css');

        // Sometimes we'll want to send scripts to the top (rarely..)
        echo $this->fetch('script');
        // echo $this->Html->script('jquery-1.11.2.min');
    ?>
</head>
<body>
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
                                <li><?= $this->Html->link(__('List ' . $controller), ['controller' => $controller, 'action' => 'index']) ?></li>
                                <li><?= $this->Html->link(__('Add ' . $controller), ['controller' => $controller, 'action' => 'add']) ?></li>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <form class="navbar-form pull-right" role="search" method="post" action="/api/keyword_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="keyword">
                        <div class="input-group-btn">
                            <input class="btn btn-default" type="submit" value="Submit" />
                            <button class="btn btn-default dropdown-toggle" type="button" id="search_adv_button" data-toggle="dropdown" aria-expanded="true">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="search_adv_button">
                                <li><?= $this->Html->link(__('Advanced Search'), '/api/keyword_search') ?></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </nav>
        </div>
    </header>
    <div class="container">
        <div id="content" class="row">
            <?= $this->Flash->render(); ?>
            <?= $this->fetch('content'); ?>
        </div>
    </div>
</body>
</html>
