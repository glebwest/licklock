<?php

$sess = $this->session;

$sess->valid = 0;

R::store($sess);

$this->answerJson('byby');