    # SimpleTpl v.1.0

    A lightweight PHP Template engine, designed to replace Smarty.

    Project goals:

     - Warning-free and neat code
     - Small and durable solution




     - FAQ -

     Q: Why no {section}{/section} controlstructure?
     A: It has been replace with {for} and {foreach}, the behaviour
        of a given function should not be dictated by it' parameters
        but by the functionname itself.

     Q: How do i get started?
     A: Download example.php, example.tpl and SimpleTpl.class.php and
        read the code, play around with it, it's pretty self-explanatory.

     Q: What's the license?
     A: GNU GPL v2 or MIT BSD, i reserve the right to re-release the coder and any contributions under
        a different license under my choosing. If you want this software under another license, please contact me.

     Q: Can i make money using this code?
     A: Sure, just keep my name in the credits and drop me a line if you do.

     - Quick and dirty reference -

    An example is worth thousands of words ... i would gladly accept help
    to do some proper documentation, both regarding the definition of the
    language and the user-guide. Get in touch mikkel@mikjaer.com

    PHP End:
    <pre>
     $stpl = new SimpleTpl();
     $stpl->assign("title","This is a demonstration of");

     $stpl->append("menu",array("name"=>"Citron",  "url"=>"http://www.citron.com"));
     $stpl->append("menu",array("name"=>"Apple",   "url"=>"http://www.apple.net"));
     $stpl->append("menu",array("name"=>"Melon",   "url"=>"http://www.melon.dk"));
     $stpl->append("menu",array("name"=>"Bazinga", "url"=>"http://www.bazinga.co.uk"));

     $menu[]=array("name"=>"Userfriendly",  "url"=>"http://www.userfriendly.org");
     $menu[]=array("name"=>"Hackles",       "url"=>"http://www.hackles.org");

     $stpl->merge("menu", $menu);

     $stpl->debug(true); // True == Development (meaningfull errors) , False == Production (speed and no infoleaks)
     
     $stpl->display("example.tpl");
     print $stpl->fetch("example.tpl");
     print $stpl->render(file_get_contents("example.tpl"));

    Template End:

     Simple macro:  {$title}

     Access array:  {$menuitem.url}

     Traverse array:{foreach name=loop loop=$menu}
                    &lt;a href="{$menu[$loop.index]}.url}">{$menu[$loop.index]}.name&lt;/a>
                {/foreach}

 For loop:      {for name=forward start=1 stop=5}
                    {$forward.count}
                {/for}

 If:            {if $test = 'a'}
                    Do stuff
                {else}
                    Do some other stuff
                {/if}

 If is set:     {if $title}
                {if !$title}
                {if ! $title}
   
 Else if:       {if 'a' == 'b'}
                    Foo
                {else if 'c' != 'c'}
                    Bar
                {else}
                    Fair'enough
                {/if}

 Operators:     {if $a == $b)   Equals
                {if $a != $b)   Different from
                {if $a < $b)    Smaller than
                {if $a > $b)    Greater than
                {if !$a == $b)  Not equal 
                {if ! $a == $b) Not equal
</pre>
