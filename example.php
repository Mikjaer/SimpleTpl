<?
    # Old non-composer way
    # include("SimpleTpl.php");
    # $smarty = new SimpleTpl();
   
    # First run: composer require mikjaer/simpletpl

    include("vendor/autoload.php");
    $smarty = new Mikjaer\SimpleTpl\SimpleTpl();

    $smarty->assign("title","This is a demonstration of");

    $smarty->append("menu",array("name"=>"Citron",  "url"=>"http://www.citron.com"));
    $smarty->append("menu",array("name"=>"Apple",   "url"=>"http://www.apple.net"));
    $smarty->append("menu",array("name"=>"Melon",   "url"=>"http://www.melon.dk"));
    $smarty->append("menu",array("name"=>"Bazinga", "url"=>"http://www.bazinga.co.uk"));

    $smarty->assign("texts",array("copyright"=>"Copyright (c) 2015 Mikkel Mikjaer Christensen"));
    $smarty->merge("texts",array("subtitle"=>"SimpleTpl template engine."));

    $smarty->display("example.tpl");
?>
