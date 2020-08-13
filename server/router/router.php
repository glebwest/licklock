<?php


# API RoutList

includeClass('Rout');

$rout = new Rout();

// create list of API's methods

$rout->setRout('test');

// all

$rout->setRout('checkToken',true);

// Main

$rout->setRout('setLink');

$rout->setRout('firstRegistration');

// Follow

$rout->setRout('getLink');

// Login

$rout->setRout('checkUserByEmail');

$rout->setRout('registration');

$rout->setRout('recover');

$rout->setRout('login');

$rout->setRout('logout',true);

// LK

$rout->setRout('getUserProfile',true);

$rout->setRout('getUserLinks',true);

$rout->setRout('getUserPayment',true);

// Stats

$rout->setRout('getLinkStats',true);

# Routing

includeClass('Rest');

$request = new Rest();

$request->init();

//$request->answerJson($request->request);

# search method

$rout->getRout($request->request);