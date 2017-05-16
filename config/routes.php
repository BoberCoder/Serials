<?php

return array(
    'episode/delete/([0-9]+)' => 'episode/delete/$1',
    'episode/([0-9]+)'=> 'episode/list/$1',
    'episode/new/([0-9]+)' => 'episode/new/$1',
    'new' => 'serial/new',
    'edit/([А_-я_]+)' => 'serial/edit/$1',
    'delete/([А_-я_]+)' => 'serial/delete/$1',
    '([А_-я_]+)' => 'serial/show/$1',
    '([0-9]+)' => 'serial/list/$1',
    '' => 'serial/list/1',

);