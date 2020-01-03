<?php

namespace Codenexus\GeoIP;

class GeoIPUpdater
{
    /**
     * Main update method.
     *
     * @return bool|string
     */
    public function update()
    {
        $databasePath = storage_path('app/geoip.mmdb');
        $licenseKey = env('MAXMIND_GEOLITE_LICENSE_KEY');
        $url = "https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key={$licenseKey}&suffix=tar.gz";

        // Download latest MaxMind GeoLite2 City database to temp location
        $tmpFile = tempnam(sys_get_temp_dir(), 'maxmind');
        file_put_contents($tmpFile, fopen($url, 'r'));

        // Extract database to proper storage location
        file_put_contents($databasePath, gzopen($tmpFile, 'r'));

        // Delete temp file
        unlink($tmpFile);

        return $databasePath;
    }
}
