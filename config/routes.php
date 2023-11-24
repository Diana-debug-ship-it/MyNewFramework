<?php

use wfm\Router;

// более конкретные правила должны находится выше общих
Router::add('^admin/?$', ['controller'=>'Main', 'action'=>'index',
    'admin_prefix' => 'admin']);
Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['controller'=>'Main', 'action'=>'index',
    'admin_prefix' => 'admin']);

Router::add('^(?P<lang>[a-z]+)?/?product/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action'=>'view']);
Router::add('^(?P<lang>[a-z]+)?/?category/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Category', 'action'=>'view']);


Router::add('^(?P<lang>[a-z-]+)?/?$', ['controller'=>'Main', 'action'=>'index']);

Router::add('^$', ['controller'=>'Main', 'action'=>'index']);
Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');