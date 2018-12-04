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
    <h2>Hämta väderinfo</h2>
    <form>
        <p>
            <label>
                Positionsnamn som: 
                <ul>
                    <li>Platsnamn <code> ex. Uppsala</code></li>
                    <li>Koordinat i mönstret <code>[LATITUD,LONGITUD]</code></li>
                    <li>Ip-adress <code> ex. 83.252.70.69</code></li>
                </ul>
            </label>
        </p>
        <p>
            <input type="text" name="pos" value="<?= $pos ?>">
        </p>
        <p>
            <label>Få svar som:</label>
            <select name="data">
                <option value="text">Text</option>
                <option value="json">JSON</option>
            </select>
        </p>
        <button type="submit">Hämta</button>
    </form>
    <?php
    if ($errorMsg) : ?>
        <pre class="error">
            <?= $errorMsg ?>
        </pre>
        <?php
    else :
        if (isset($currently)) :
            include "currentWeather.php";
        endif;
        if (isset($hours)) :
            include "hourlyWeather.php";
        endif;
        if (isset($days)) :
            include "dailyWeather.php";
        endif;
        if (isset($pastDays)) :
            include "pastWeather.php";
        endif;
    endif;
    ?>
    <a href="https://darksky.net/poweredby/">Powered by DarkSky</a>
    <a href="https://darkskyapp.github.io/skycons/">Icons from Skycons</a>
    <a href="https://opencagedata.com">Geocoding from OpenCage Data Ltd.</a>
    <a href="https://ipstack.com/">Ip info from ipstack</a>
</div>
<?php if (isset($script)) : ?>
    <script type="text/javascript"><?= $script ?></script>
<?php endif; ?>
