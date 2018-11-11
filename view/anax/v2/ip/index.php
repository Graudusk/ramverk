<?php

namespace Anax\View;

/**
 * Template file to render a view with content.
 */

// Show incoming variables and view helper functions
// echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare incoming variables
$class   = $class ?? null;
$content = $content ?? null;

$url     = $di->get("url");
$request     = $di->get("request");


?><div class="$class">
    <h2>Validera ip-adress</h2>
    <p>
        För att validera en ip-adress med mitt API görs ett GET- eller POST-anrop till ip/json. Görs ett GET-anrop måste query string ?ip=[ip-adress]. T. ex: <a href="<?php echo $url->createRelative("ip/json") ?>?ip=1.1.1.1">ip/json?ip=1.1.1.1</a>
    </p>
    <ul>
        <li>
            <a href="<?php echo $url->createRelative("ip/validate") ?>">
                Validera Ip-adress
            </a>
        </li>
        <li>
            <a href="<?php echo $url->createRelative("ip/json") ?>?ip=123.123.123.123">
                Validera 123.123.123.123, få JSON-svar
            </a>
        </li>
        <li>
            <a href="<?php echo $url->createRelative("ip/validate") ?>?ip=123.123.123.123">
                Validera 123.123.123.123
            </a>
        </li>
        <li>
            <a href="<?php echo $url->createRelative("ip/validate") ?>?ip=<?= $request->getServer("REMOTE_ADDR") ?>">Validera <?= $request->getServer("REMOTE_ADDR") ?></a>
        </li>
        <li>
            <a href="<?php echo $url->createRelative("ip/validate") ?>?ip=2001:0db8:85a3:08d3:1319:8a2e:0370:7334">Validera 2001:0db8:85a3:08d3:1319:8a2e:0370:7334</a>
        </li>
        <li>
            <a href="<?php echo $url->createRelative("ip/json") ?>?ip=2001:0db8:85a3:08d3:1319:8a2e:0370:7334">Validera 2001:0db8:85a3:08d3:1319:8a2e:0370:7334, få JSON-svar</a>
        </li>
    </ul>
</div>
