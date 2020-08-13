<?php

# RENDER Router

includeClass('Rout');

$rout = new Rout();

# RoutList

$rout->setRout('error');

$rout->setRout('thanks');

$rout->setRout('pay');

$rout->setRout('login');

//

$rout->setRout('lk');

# Routing

includeClass('Req');

$request = new Req();

$rout->id = $request->id;

# search page

$rout->getRout($request->name);