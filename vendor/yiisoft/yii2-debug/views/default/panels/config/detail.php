<?php
/* @var $panel yii\debug\panels\ConfigPanel */
$extensions = $panel->getExtensions();
?>
<h1>Configuration</h1>

<?php
echo $this->render('table', [
    'caption' => 'Application Configuration',
    'values' => [
        'Yii Version' => $panel->data['application']['yii'],
        'Application Name' => $panel->data['application']['name'],
        'Application Version' => $panel->data['application']['version'],
        'Environment' => $panel->data['application']['env'],
        'Debug Mode' => $panel->data['application']['debug'] ? 'Yes' : 'No',
    ],
]);

if (!empty($extensions)) {
    echo $this->render('table', [
        'caption' => 'Installed Extensions',
        'values' => $extensions,
    ]);
}

$memcache = 'Disabled';
if ($panel->data['php']['memcache']) {
    $memcache = 'Enabled (memcache)';
} elseif ($panel->data['php']['memcached']) {
    $memcache = 'Enabled (memcached)';
}

echo $this->render('table', [
    'caption' => 'PHP Configuration',
    'values' => [
        'PHP Version' => $panel->data['php']['version'],
        'Xdebug' => $panel->data['php']['xdebug'] ? 'Enabled' : 'Disabled',
        'APC' => $panel->data['php']['apc'] ? 'Enabled' : 'Disabled',
        'Memcache' =>  $memcache,
    ],
]);

echo $panel->getPhpInfo();
