<?php

namespace Anax\View;

/**
 * Template file to render a view with content.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare incoming variables
$class   = $class ?? null;
$content = $content ?? null;



?><div class="$class">
    <h2>Validera ip-adress</h2>
    <form>
        <p>
            <label>Ip-adress:</label>
            <input type="text" name="ip" value="<?= $ip ?>">
        </p>
        <p>
            <label>Få svar som:</label>
            <select name="data">
                <option value="text">Text</option>
                <option value="json">JSON</option>
            </select>
        </p>
        <button type="submit">Validera</button>
    </form>
    <?php if (isset($message)) : ?>
        <pre>
            <?= $message?>

            Domän: <?= $host ? $host : "-" ?>
        </pre>
    <?php elseif ($errorMsg) : ?>
        <pre class="error">
            <?= $errorMsg ?>
        </pre>
    <?php endif ?>
</div>
