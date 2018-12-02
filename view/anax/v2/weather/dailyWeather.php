<section class="dailyRows">
<h2>Prognos (dagsvis)</h2>
<?php foreach ($days as $day) : ?>
    <div class="row">
        <h3><?= $day["weekday"] ?>, <?= $day["date"] ?></h3>
        <article class="weatherBox <?= $day['icon'] ?>">
        <div class="col-sm-6 forecastBox">
            <p><strong><?= $day["summary"] ?></strong></p>
            <p>Högsta temperatur: <?= $day["temperatureMax"]?>&deg;&nbsp;<small>(<?=$day["apparentTemperatureMax"]?>&deg;)</small></p>
            <p>Lägsta temperatur: <?= $day["temperatureMin"]?>&deg;&nbsp;<small>(<?=$day["apparentTemperatureMin"]?>&deg;)</small></p>
        </div>
        <div class="col-sm-6 text-center">
            <p><canvas id="icon<?= $day["time"] ?>" width="128" height="128"></canvas></p>
        </div>
        </article>
    </div>
<?php endforeach ?>
</section>
