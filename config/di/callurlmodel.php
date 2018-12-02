<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "callurlmodel" => [
            "shared" => true,
            "callback" => function () {
                $curlModel = new \Erjh17\CallUrlModel\CallUrlModel();
                $curlModel->setDI($this);

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("callurlmodel.php");
                $file = $config["file"] ?? null;
                $config = $config["config"] ?? null;

                $ipstackurl = $config["ipstackurl"] ?? null;
                $darkskyurl = $config["darkskyurl"] ?? null;
                $opencageurl = $config["opencageurl"] ?? null;


                $ipstackkey = $config["ipstackkey"] ?? null;
                $darkskykey = $config["darkskykey"] ?? null;
                $opencagekey = $config["opencagekey"] ?? null;

                if (!$ipstackkey) {
                    throw new Exception("Configuration file '$file': Missing api key for Ip Stack.");
                } elseif (!$darkskykey) {
                    throw new Exception("Configuration file '$file': Missing api key for Dark Sky.");
                } elseif (!$opencagekey) {
                    throw new Exception("Configuration file '$file': Missing api key for Opencage.");
                }

                if (!$ipstackurl) {
                    throw new Exception("Configuration file '$file': Missing api url for Ip Stack.");
                } elseif (!$darkskyurl) {
                    throw new Exception("Configuration file '$file': Missing api url for Dark Sky.");
                } elseif (!$opencageurl) {
                    throw new Exception("Configuration file '$file': Missing api url for Opencage.");
                }

                $curlModel->setIpstackKey($ipstackkey);
                $curlModel->setDarkskyKey($darkskykey);
                $curlModel->setOpencageKey($opencagekey);

                $curlModel->setIpstackUrl($ipstackurl);
                $curlModel->setDarkskyUrl($darkskyurl);
                $curlModel->setOpenCageUrl($opencageurl);

                return $curlModel;
            }
        ],
    ],
];
