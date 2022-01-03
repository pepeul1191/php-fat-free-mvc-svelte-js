<?php

ORM::configure('sqlite:' . FCPATH . DIRECTORY_SEPARATOR . 'db'. DIRECTORY_SEPARATOR . 'data.db',  null, 'classroom');
ORM::configure('return_result_sets', true);
ORM::configure('error_mode', PDO::ERRMODE_WARNING);
ORM::configure('logging', true);
