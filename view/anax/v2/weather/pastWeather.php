<section class="pastDays">
<h2>Tidigare väder (dagsvis)</h2>
<div class="row">
    <?php foreach ($pastDays as $day) : ?>
        <div class="col-sm-6 forecastBox weatherBox <?= $day['icon'] ?>">
            <p><strong><?= $day["weekday"] ?>, <?= $day["date"] ?></strong></p>
            <p><strong><?= $day["summary"] ?></strong></p>
            <p>Högsta temperatur: <?= $day["temperatureMax"]?>&deg;&nbsp;<small>(<?=$day["apparentTemperatureMax"]?>&deg;)</small></p>
            <p>Lägsta temperatur: <?= $day["temperatureMin"]?>&deg;&nbsp;<small>(<?=$day["apparentTemperatureMin"]?>&deg;)</small></p>
        </div>
    <?php endforeach ?>
</div>
</section>
