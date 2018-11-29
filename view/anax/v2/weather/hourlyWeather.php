<h2>Prognos (timvis)</h2>
<div class="row">
    <div class="col-sm-12">
        <?php foreach ($hours["days"] as $day) : ?>
            <h3><?= $day["day"] ?></h3>
            <div class="row">
                <?php foreach ($day["hours"] as $hour) : ?>
                    <div class="col-sm-3 forecastBox weatherBox <?= $hour["icon"]?>">
                        <p><strong><?= $hour["timeofday"] ?></strong></p>
                        <p><?= $hour["summary"] ?></p>
                        <p>Temperatur: <?= $hour["temperature"]?>&deg;&nbsp;<small>(<?=$hour["apparentTemperature"]?>&deg;)</small></p>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endforeach ?>
    </div>
</div>
