<h3>Idag - <?=$currently["weekday"]?>, <?=$currently["date"]?>, <?=$currently["timeofday"]?></h3>
<div class="row weatherBox <?= $currently['icon'] ?>">
    <div class="col-sm-6 text-left">
        <div class="row">
            <div class="col-sm-4">
                <h4><?= $currently["temperature"]?>&deg;</h4>
                <h4><small>(<?=$currently["apparentTemperature"]?>&deg;)</small></h4>
            </div>
            <div class="col-sm-8">
                <canvas id="icon1" width="128" height="128"></canvas>
            </div>
        </div>
        <h4><?= $currently["summary"] ?></h4>
        <p>Vindhastighet: <?= $currently["windSpeed"] ?> m/s</p>
        <p>Risk för nederbörd: <?= $currently["precipProbability"] ?></p>
        <p>Lufttryck: <?= $currently["pressure"] ?> hPa</p>
    </div>
    <div class="col-sm-6">
        <?php if ($latitude) : ?>
            <h4><?= $positionName ?></h4>
            <div id="map"></div>
        <?php else : ?>
            <p>Ingen geografisk data kunde hittas.</p>
        <?php endif ?>
    </div>
</div>
