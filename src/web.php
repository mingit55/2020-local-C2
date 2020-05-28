<?php

use App\Router;


// # etc.
Router::get("/", "MainController@indexPage");
Router::get("/online-store", "MainController@storePage");

// # 유저
Router::post("/sign-in", "UserController@signIn");
Router::post("/sign-up", "UserController@signUp");
Router::get("/sign-up/captcha", "UserController@captchaImage");
Router::get("/logout", "UserController@logout", "user");


// # 온라인 집들이
Router::get("/online-party", "MainController@partyPage", "user");
Router::post("/online-party/knowhows", "MainController@writeKnowhow", "user");
Router::post("/online-party/scores", "MainController@scoreKnowhow", "user");


// # 전문가
Router::get("/specialist", "UserController@specialistPage", "user");
Router::post("/specialist/reviews", "UserController@writeReview", "user");

Router::get("/estimate", "MainController@estimatePage", "user");
Router::post("/estimate/requests", "MainController@writeRequest", "user");

Router::execute();