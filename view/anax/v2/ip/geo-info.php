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

?>

<div class="$class">
    <h2>Hämta geografisk information</h2>
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
        <button type="submit">Hämta info</button>
    </form>
    <?php if (isset($message)) : ?>
        <pre>
            <?= $message?>

            Domän: <?= $host?>

            <?php if ($latitude) : ?>
Plats: <?= $continent_name?>, <?= $country_name?>, <?= $city?>

            Postnr: <?= $zip?>

            Koordinat: <?= $latitude?>, <?= $longitude?>
            <?php else : ?>
Ingen geografisk data kunde hittas.
            <?php endif ?>
        </pre>

    <?php elseif ($errorMsg) : ?>
        <pre class="error">
            <?= $errorMsg ?>
        </pre>
    <?php endif ?>
    <div id="map"></div>
</div>


<script type="text/javascript">
    window.addEventListener('load', function() {
        window.initMap(<?= $longitude?>, <?= $latitude?>, <?= $zoomLevel?>, <?= $radius?>);
    });
</script>
