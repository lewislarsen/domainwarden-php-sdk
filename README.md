# PHP SDK

## About

Welcome to the PHP SDK of Domainwarden.

This package is designed to easily incorporate aspects of Domainwarden into your project.

Our API docs can be viewed here: https://docs.domainwarden.app/api/introduction.



To install this package please run the following command in your terminal:

```
composer require domainwarden/sdk
```

## Use

To use the SDK, here are some examples below:

```
# Your .env should contain this!
DOMAINWARDEN_API_TOKEN=123456
```

```php
<?php

use Domainwarden\Sdk\Facades\Domainwarden;
use Domainwarden\Sdk\DataTransferObjects\CreateDomainRequest;
use Domainwarden\Sdk\DataTransferObjects\UpdateDomainRequest;
use Domainwarden\Sdk\DataTransferObjects\CreateNotificationChannelRequest;
use Domainwarden\Sdk\DataTransferObjects\UpdateNotificationChannelRequest;

// User
$user = Domainwarden::getUser();
$intervals = Domainwarden::getCheckIntervals();

// Domains
$domains = Domainwarden::domains(page: 2);

$domainRequest = new CreateDomainRequest(
    domain: 'example.com',
    check_interval: 'daily',
    monitor_whois: true,
    monitor_dns: true,
    monitor_ssl: true
);
$newDomain = Domainwarden::createDomain($domainRequest);

$domain = Domainwarden::getDomain('domain-id-123');

$updateRequest = new UpdateDomainRequest(check_interval: 'weekly');
$updatedDomain = Domainwarden::updateDomain('domain-id-123', $updateRequest);

Domainwarden::deleteDomain('domain-id-123');

$toggle = Domainwarden::toggleDomain('domain-id-123');
Domainwarden::toggleWhoisMonitoring('domain-id-123');
Domainwarden::toggleDnsMonitoring('domain-id-123');
Domainwarden::toggleSslMonitoring('domain-id-123');

Domainwarden::checkWhois('domain-id-123');
Domainwarden::checkDns('domain-id-123');

$whoisChanges = Domainwarden::getWhoisChanges('domain-id-123', page: 1, perPage: 20);
$whoisChange = Domainwarden::getWhoisChange('domain-id-123', 'change-id-456');

$dnsChanges = Domainwarden::getDnsChanges('domain-id-123');
$dnsChange = Domainwarden::getDnsChange('domain-id-123', 'change-id-789');

// Notification Channels
$channels = Domainwarden::getNotificationChannels('domain-id-123');

$channelRequest = new CreateNotificationChannelRequest(
    type: 'email',
    value: 'alert@example.com',
    events: ['whois_change', 'dns_change']
);
$newChannel = Domainwarden::createNotificationChannel('domain-id-123', $channelRequest);

$channel = Domainwarden::getNotificationChannel('domain-id-123', 'channel-id-abc');

$updateChannelRequest = new UpdateNotificationChannelRequest(events: ['ssl_expiry']);
$updatedChannel = Domainwarden::updateNotificationChannel('domain-id-123', 'channel-id-abc', $updateChannelRequest);

Domainwarden::bulkAssignNotificationChannels(
    targetDomainId: 'target-id',
    sourceDomainId: 'source-id',
    notificationChannelIds: ['chan-1', 'chan-2']
);

Domainwarden::deleteNotificationChannel('domain-id-123', 'channel-id-abc');

// Notification History
$history = Domainwarden::getNotificationHistory('domain-id-123', page: 2);
$historyItem = Domainwarden::getNotificationHistoryItem('domain-id-123', 'hist-id-xyz');

// Activity Logs
$logs = Domainwarden::getActivityLogs('domain-id-123', perPage: 30);
$logItem = Domainwarden::getActivityLogItem('domain-id-123', 'log-id-def');
```


## License

This package is licensed under the MIT license.