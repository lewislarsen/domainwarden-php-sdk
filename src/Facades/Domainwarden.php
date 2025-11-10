<?php

namespace Domainwarden\Sdk\Facades;

use Domainwarden\Sdk\DataTransferObjects\ActivityLogItem;
use Domainwarden\Sdk\DataTransferObjects\BulkNotificationChannelResponse;
use Domainwarden\Sdk\DataTransferObjects\ComponentToggleResponse;
use Domainwarden\Sdk\DataTransferObjects\CreateDomainRequest;
use Domainwarden\Sdk\DataTransferObjects\DnsChange;
use Domainwarden\Sdk\DataTransferObjects\Domain;
use Domainwarden\Sdk\DataTransferObjects\DomainToggleResponse;
use Domainwarden\Sdk\DataTransferObjects\NotificationChannel;
use Domainwarden\Sdk\DataTransferObjects\NotificationHistoryItem;
use Domainwarden\Sdk\DataTransferObjects\PaginatedResponse;
use Domainwarden\Sdk\DataTransferObjects\UpdateDomainRequest;
use Domainwarden\Sdk\DataTransferObjects\User;
use Domainwarden\Sdk\DataTransferObjects\WhoisChange;
use Illuminate\Support\Facades\Facade;

/**
 * @method static User user()
 * @method static array getCheckIntervals()
 * @method static PaginatedResponse domains(int $page = 1)
 * @method static Domain createDomain(CreateDomainRequest $request)
 * @method static Domain getDomain(string $id)
 * @method static Domain updateDomain(string $id, UpdateDomainRequest $request)
 * @method static bool deleteDomain(string $id)
 * @method static DomainToggleResponse toggleDomain(string $domainId)
 * @method static ComponentToggleResponse toggleWhoisMonitoring(string $domainId)
 * @method static ComponentToggleResponse toggleDnsMonitoring(string $domainId)
 * @method static ComponentToggleResponse toggleSslMonitoring(string $domainId)
 * @method static string checkWhois(string $domainId)
 * @method static string checkDns(string $domainId)
 * @method static PaginatedResponse getWhoisChanges(string $domainId, int $page = 1, int $perPage = 15)
 * @method static WhoisChange getWhoisChange(string $domainId, string $whoisChangeId)
 * @method static PaginatedResponse getDnsChanges(string $domainId, int $page = 1, int $perPage = 15)
 * @method static DnsChange getDnsChange(string $domainId, string $dnsChangeId)
 * @method static PaginatedResponse getNotificationChannels(string $domainId, int $page = 1)
 * @method static NotificationChannel createNotificationChannel(string $domainId, CreateNotificationChannelRequest $request)
 * @method static NotificationChannel getNotificationChannel(string $domainId, string $channelId)
 * @method static NotificationChannel updateNotificationChannel(string $domainId, string $channelId, UpdateNotificationChannelRequest $request)
 * @method static BulkNotificationChannelResponse bulkAssignNotificationChannels(string $targetDomainId, string $sourceDomainId, array $notificationChannelIds)
 * @method static bool deleteNotificationChannel(string $domainId, string $channelId)
 * @method static PaginatedResponse getNotificationHistory(string $domainId, int $page = 1)
 * @method static NotificationHistoryItem getNotificationHistoryItem(string $domainId, string $historyId)
 * @method static PaginatedResponse getActivityLogs(string $domainId, int $page = 1, int $perPage = 15)
 * @method static ActivityLogItem getActivityLogItem(string $domainId, string $logId)
 *
 * @see \Domainwarden\Sdk\DomainwardenClient
 */
class Domainwarden extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'domainwarden';
    }
}
