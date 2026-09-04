<?php

namespace backend\assets;

use yii\web\AssetBundle;

class LeafletAsset extends AssetBundle
{
    public $css = [
        'https://unpkg.com/leaflet/dist/leaflet.css',
        'https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css',
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css',
        // Tambahkan URL CSS untuk Leaflet.StreetView jika ada
    ];
    public $js = [
        'https://unpkg.com/leaflet/dist/leaflet.js',
        'https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js',
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js',
        'https://cdn.jsdelivr.net/gh/leaflet-extras/leaflet-providers/leaflet-providers.js', // contoh tambahan
        'https://unpkg.com/leaflet-streetview/dist/leaflet-streetview.js' // contoh tambahan
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
