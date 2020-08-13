<?php

function includeClass($className) {
    return( include_once constant('CLASS') . $className . ".php");
}