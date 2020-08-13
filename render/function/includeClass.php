<?php

function includeClass($className) {
    return( include constant('CLASS') . $className . ".php");
}