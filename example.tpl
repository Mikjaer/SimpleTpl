<html>
    <head>
        <title>{$title}</title>
    </head>
    <body>
        <h1>{$title}</h1>
        <h2>{$texts.subtitle}</h2>

        Menu:
        <ul>
        {foreach name=nisse loop=$menu}
            <li><a href="{$menu[$nisse.index].url}">{$menu[$nisse.index].name}</a></li>
        {/foreach}
        </ul>

        Loop:
        <table border=1>
        {for name=forward start=1 stop=5}
            <tr>
                <td>
                    {$forward.count}
                </td>
                {for name=backward start=5 stop=1}
                    <td>
                        {$backward.count}
                    </td>
                {/for}

            </tr>
        {/for}
        </table>
 
    {assign var=$test value="TEST"}
    {$test}

    {$texts.copyright}
    </body>
</html>
