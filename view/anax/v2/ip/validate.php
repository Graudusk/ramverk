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
        <button type="submit">Validera</button>
    </form>
    <?php if ($content): ?>
        <pre>
<?= $content?>

Domän: <?= $server?>
        </pre>
    <?php endif ?>
</div>
