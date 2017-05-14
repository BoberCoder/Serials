<?php

return array(
    'episode/new' => 'episode/new',
    'new' => 'serial/new',
    'edit/([А_-я_]+)' => 'serial/edit/$1',
    'delete/([А_-я_]+)' => 'serial/delete/$1',
    '([А_-я_]+)' => 'serial/show/$1',
    '' => 'serial/list',
);