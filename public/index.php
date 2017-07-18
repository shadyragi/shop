<?php
require_once '../vendor/autoload.php';
require_once 'route.php';
$route = new route();

$route->get("home", "homecontroller:getproducts");
$route->get("details/{id:int}", "productdetailscontroller:find");
$route->get("login", "logincontroller:getform");
$route->post("login", "logincontroller:postform");
$route->get("logout", "logincontroller:logout");
$route->get("cart", "cartcontroller:getcartproducts");
$route->get("signup", "logincontroller:getsignupform");
$route->post("signup", "logincontroller:postsignupform");
$route->post("addproduct", "cartandwishlistcontroller:addproduct");
$route->get("wishlist", "wishlistcontroller:getwishlistproducts");
$route->get("notifications", "notificationscontroller:getnotifications");
$route->post("deletenotification", "notificationscontroller:deletenotification");
$route->get("registry", "registrycontroller:get");
$route->post("editcart", "cartcontroller:editcart");
$route->post("editwishlist", "wishlistcontroller:editwishlist");
$route->post("search", "searchcontroller:search");
$route->get("history", "historycontroller:gethistory");
$route->post("deletehistory/{id:int}", "historycontroller:deletehistory");
$route->get("myaccount", "accountcontroller:getaccount");
$route->post("myaccount", "accountcontroller:updateaccount");
$route->get("admin/products", "admincontroller:changelocation");
$route->get("admin/products/{id:int}", "admincontroller:getproducts");
$route->post("admin/products/{id:int}", "admincontroller:getproducts");
$route->post("admin/deleteproduct/{id:int}", "admincontroller:deleteproduct");
$route->get("admin/editproduct/{id:int}" ,"admincontroller:geteditproduct");
$route->post("admin/editproduct/{id:int}", "admincontroller:editproduct");
$route->get("admin/addproduct", "admincontroller:getaddproductform");
$route->post("admin/addproduct", "admincontroller:addproduct");
$route->get("admin/products/filter", "admincontroller:filterproduct");
$route->get("admin/users", "usercontroller:changelocation");
$route->get("admin/users/{id:int}", "usercontroller:getusers");
$route->post("admin/users/{id:int}", "usercontroller:getusers");
$route->get("admin/user/edituser/{id:int}", "usercontroller:edituser");
$route->post("admin/deleteuser/{id:int}", "usercontroller:deleteuser");
$route->get("admin/adduser", "usercontroller:getadduserform");
$route->post("admin/adduser", "usercontroller:adduser");
$route->get("admin/categories", "categcontroller:changelocation");
$route->get("admin/categories/{id:int}", "categcontroller:getcategs");
$route->post("admin/categories/{id:int}", "categcontroller:getcategs");
$route->post("admin/deletecateg/{id:int}", "categcontroller:deletecateg");
$route->get("admin/addcateg", "categcontroller:getaddcategform");
$route->post("admin/addcateg", "categcontroller:addcateg");
$route->get("admin/login", "adminlogincontroller:getloginform");
$route->post("admin/login", "adminlogincontroller:postform");
$route->get("admin/logout", "adminlogincontroller:logout");
$route->get("admin/find/{id:int}", "admincontroller:find");
header("Location: http://localhost/shop/public/home");



?>