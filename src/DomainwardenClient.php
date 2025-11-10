<?php

namespace Domainwarden\Sdk;

use Domainwarden\Sdk\DataTransferObjects\ActivityLogItem;
use Domainwarden\Sdk\DataTransferObjects\BulkNotificationChannelResponse;
use Domainwarden\Sdk\DataTransferObjects\ComponentToggleResponse;
use Domainwarden\Sdk\DataTransferObjects\CreateDomainRequest;
use Domainwarden\Sdk\DataTransferObjects\CreateNotificationChannelRequest;
use Domainwarden\Sdk\DataTransferObjects\DnsChange;
use Domainwarden\Sdk\DataTransferObjects\Domain;
use Domainwarden\Sdk\DataTransferObjects\DomainToggleResponse;
use Domainwarden\Sdk\DataTransferObjects\NotificationChannel;
use Domainwarden\Sdk\DataTransferObjects\NotificationHistoryItem;
use Domainwarden\Sdk\DataTransferObjects\PaginatedResponse;
use Domainwarden\Sdk\DataTransferObjects\UpdateDomainRequest;
use Domainwarden\Sdk\DataTransferObjects\UpdateNotificationChannelRequest;
use Domainwarden\Sdk\DataTransferObjects\User;
use Domainwarden\Sdk\DataTransferObjects\WhoisChange;
use Domainwarden\Sdk\Exceptions\DomainwardenException;
use Domainwarden\Sdk\Exceptions\NotFoundException;
use Domainwarden\Sdk\Exceptions\RateLimitExceededException;
use Domainwarden\Sdk\Exceptions\SubscriptionRequiredException;
use Domainwarden\Sdk\Exceptions\UnauthenticatedException;
use Domainwarden\Sdk\Exceptions\ValidationException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DomainwardenClient
{
    protected string $apiToken;

    protected string $apiUrl = 'https://domainwarden.app/api';

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    /**
     * Get the currently authenticated user's information.
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function user(): User
    {
        $response = $this->request('get', 'user');

        return User::fromArray($response->json() ?? []);
    }

    /**
     * Get available check intervals for the authenticated user.
     * The intervals returned depend on the user's subscription plan.
     *
     * @return array Array of available interval strings (e.g., ['hourly', 'daily', 'weekly'])
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getCheckIntervals(): array
    {
        $response = $this->request('get', 'user/check-intervals');

        return $response->json('data', []);
    }

    /**
     * Get a paginated list of domains.
     *
     * @param  int  $page  The page number to retrieve (default: 1)
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function domains(int $page = 1): PaginatedResponse
    {
        $response = $this->request('get', "domains?page={$page}");

        return PaginatedResponse::fromArray(
            $response->json() ?? [],
            fn ($item) => Domain::fromArray($item)
        );
    }

    /**
     * Create a new domain.
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function createDomain(CreateDomainRequest $request): Domain
    {
        $response = $this->request('post', 'domains', $request->toArray());

        return Domain::fromArray($response->json() ?? []);
    }

    /**
     * Get a specific domain by ID.
     *
     * @param  string  $id  The domain ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getDomain(string $id): Domain
    {
        $response = $this->request('get', "domains/{$id}");

        return Domain::fromArray($response->json() ?? []);
    }

    /**
     * Update an existing domain.
     *
     * @param  string  $id  The domain ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     * @throws ValidationException
     */
    public function updateDomain(string $id, UpdateDomainRequest $request): Domain
    {
        $response = $this->request('patch', "domains/{$id}", $request->toArray());

        return Domain::fromArray($response->json('data') ?? []);
    }

    /**
     * Delete a domain.
     *
     * @param  string  $id  The domain ID
     * @return bool Returns true if deletion was successful
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function deleteDomain(string $id): bool
    {
        $this->request('delete', "domains/{$id}");

        return true;
    }

    /**
     * Toggle domain monitoring (master switch).
     * Enables or disables all monitoring for the domain.
     *
     * @param  string  $domainId  The domain ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function toggleDomain(string $domainId): DomainToggleResponse
    {
        $response = $this->request('post', "domains/{$domainId}/toggle");

        return DomainToggleResponse::fromArray($response->json() ?? []);
    }

    /**
     * Toggle WHOIS monitoring for a domain.
     *
     * @param  string  $domainId  The domain ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function toggleWhoisMonitoring(string $domainId): ComponentToggleResponse
    {
        $response = $this->request('post', "domains/{$domainId}/toggle/whois");

        return ComponentToggleResponse::fromArray($response->json() ?? []);
    }

    /**
     * Toggle DNS monitoring for a domain.
     *
     * @param  string  $domainId  The domain ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function toggleDnsMonitoring(string $domainId): ComponentToggleResponse
    {
        $response = $this->request('post', "domains/{$domainId}/toggle/dns");

        return ComponentToggleResponse::fromArray($response->json() ?? []);
    }

    /**
     * Toggle SSL monitoring for a domain.
     *
     * @param  string  $domainId  The domain ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function toggleSslMonitoring(string $domainId): ComponentToggleResponse
    {
        $response = $this->request('post', "domains/{$domainId}/toggle/ssl");

        return ComponentToggleResponse::fromArray($response->json() ?? []);
    }

    /**
     * Trigger a manual WHOIS check for a domain.
     * Rate-limited to once every two hours per domain.
     *
     * @param  string  $domainId  The domain ID
     * @return string Success message
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     * @throws ValidationException
     */
    public function checkWhois(string $domainId): string
    {
        $response = $this->request('post', "domains/{$domainId}/check/whois");

        return $response->json('message', 'WHOIS check has been queued.');
    }

    /**
     * Trigger a manual DNS check for a domain.
     * Rate-limited to once every two hours per domain.
     *
     * @param  string  $domainId  The domain ID
     * @return string Success message
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     * @throws ValidationException
     */
    public function checkDns(string $domainId): string
    {
        $response = $this->request('post', "domains/{$domainId}/check/dns");

        return $response->json('message', 'DNS check has been queued.');
    }

    /**
     * Get paginated WHOIS changes for a domain.
     *
     * @param  string  $domainId  The domain ID
     * @param  int  $page  Page number
     * @param  int  $perPage  Items per page (max 100)
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getWhoisChanges(string $domainId, int $page = 1, int $perPage = 15): PaginatedResponse
    {
        $response = $this->request('get', "domains/{$domainId}/changes/whois?page={$page}&per_page={$perPage}");

        return PaginatedResponse::fromArray(
            $response->json() ?? [],
            fn ($item) => WhoisChange::fromArray($item)
        );
    }

    /**
     * Get a specific WHOIS change.
     *
     * @param  string  $domainId  The domain ID
     * @param  string  $whoisChangeId  The WHOIS change ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getWhoisChange(string $domainId, string $whoisChangeId): WhoisChange
    {
        $response = $this->request('get', "domains/{$domainId}/changes/whois/{$whoisChangeId}");

        return WhoisChange::fromArray($response->json() ?? []);
    }

    /**
     * Get paginated DNS changes for a domain.
     *
     * @param  string  $domainId  The domain ID
     * @param  int  $page  Page number
     * @param  int  $perPage  Items per page (max 100)
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getDnsChanges(string $domainId, int $page = 1, int $perPage = 15): PaginatedResponse
    {
        $response = $this->request('get', "domains/{$domainId}/changes/dns?page={$page}&per_page={$perPage}");

        return PaginatedResponse::fromArray(
            $response->json() ?? [],
            fn ($item) => DnsChange::fromArray($item)
        );
    }

    /**
     * Get a specific DNS change.
     *
     * @param  string  $domainId  The domain ID
     * @param  string  $dnsChangeId  The DNS change ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getDnsChange(string $domainId, string $dnsChangeId): DnsChange
    {
        $response = $this->request('get', "domains/{$domainId}/changes/dns/{$dnsChangeId}");

        return DnsChange::fromArray($response->json() ?? []);
    }

    /**
     * Get paginated notification channels for a domain.
     *
     * @param  string  $domainId  The domain ID
     * @param  int  $page  Page number
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getNotificationChannels(string $domainId, int $page = 1): PaginatedResponse
    {
        $response = $this->request('get', "domains/{$domainId}/notification-channels?page={$page}");

        return PaginatedResponse::fromArray(
            $response->json() ?? [],
            fn ($item) => NotificationChannel::fromArray($item)
        );
    }

    /**
     * Create a new notification channel for a domain.
     *
     * @param  string  $domainId  The domain ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     * @throws ValidationException
     */
    public function createNotificationChannel(string $domainId, CreateNotificationChannelRequest $request): NotificationChannel
    {
        $response = $this->request('post', "domains/{$domainId}/notification-channels", $request->toArray());

        return NotificationChannel::fromArray($response->json('data') ?? []);
    }

    /**
     * Get a specific notification channel.
     *
     * @param  string  $domainId  The domain ID
     * @param  string  $channelId  The notification channel ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getNotificationChannel(string $domainId, string $channelId): NotificationChannel
    {
        $response = $this->request('get', "domains/{$domainId}/notification-channels/{$channelId}");

        return NotificationChannel::fromArray($response->json() ?? []);
    }

    /**
     * Update a notification channel.
     *
     * @param  string  $domainId  The domain ID
     * @param  string  $channelId  The notification channel ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     * @throws ValidationException
     */
    public function updateNotificationChannel(string $domainId, string $channelId, UpdateNotificationChannelRequest $request): NotificationChannel
    {
        $response = $this->request('patch', "domains/{$domainId}/notification-channels/{$channelId}", $request->toArray());

        return NotificationChannel::fromArray($response->json('data') ?? []);
    }

    /**
     * Bulk copy notification channels from another domain.
     *
     * @param  string  $targetDomainId  The target domain ID to copy channels to
     * @param  string  $sourceDomainId  The source domain ID to copy from
     * @param  array  $notificationChannelIds  Array of channel IDs to copy
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     * @throws ValidationException
     */
    public function bulkAssignNotificationChannels(string $targetDomainId, string $sourceDomainId, array $notificationChannelIds): BulkNotificationChannelResponse
    {
        $response = $this->request('post', "domains/{$targetDomainId}/notification-channels/bulk", [
            'source_domain_id' => $sourceDomainId,
            'notification_channel_ids' => $notificationChannelIds,
        ]);

        return BulkNotificationChannelResponse::fromArray($response->json() ?? []);
    }

    /**
     * Delete a notification channel.
     *
     * @param  string  $domainId  The domain ID
     * @param  string  $channelId  The notification channel ID
     * @return bool Returns true if deletion was successful
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function deleteNotificationChannel(string $domainId, string $channelId): bool
    {
        $this->request('delete', "domains/{$domainId}/notification-channels/{$channelId}");

        return true;
    }

    /**
     * Get paginated notification history for a domain.
     *
     * @param  string  $domainId  The domain ID
     * @param  int  $page  Page number
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getNotificationHistory(string $domainId, int $page = 1): PaginatedResponse
    {
        $response = $this->request('get', "domains/{$domainId}/notification-channels/history?page={$page}");

        return PaginatedResponse::fromArray(
            $response->json() ?? [],
            fn ($item) => NotificationHistoryItem::fromArray($item)
        );
    }

    /**
     * Get a specific notification history entry.
     *
     * @param  string  $domainId  The domain ID
     * @param  string  $historyId  The notification history ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getNotificationHistoryItem(string $domainId, string $historyId): NotificationHistoryItem
    {
        $response = $this->request('get', "domains/{$domainId}/notification-channels/history/{$historyId}");

        return NotificationHistoryItem::fromArray($response->json() ?? []);
    }

    /**
     * Get paginated activity logs for a domain.
     *
     * @param  string  $domainId  The domain ID
     * @param  int  $page  Page number
     * @param  int  $perPage  Items per page (max 100)
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getActivityLogs(string $domainId, int $page = 1, int $perPage = 15): PaginatedResponse
    {
        $response = $this->request('get', "domains/{$domainId}/activity-logs?page={$page}&per_page={$perPage}");

        return PaginatedResponse::fromArray(
            $response->json() ?? [],
            fn ($item) => ActivityLogItem::fromArray($item)
        );
    }

    /**
     * Get a specific activity log entry.
     *
     * @param  string  $domainId  The domain ID
     * @param  string  $logId  The activity log ID
     *
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function getActivityLogItem(string $domainId, string $logId): ActivityLogItem
    {
        $response = $this->request('get', "domains/{$domainId}/activity-logs/{$logId}");

        return ActivityLogItem::fromArray($response->json() ?? []);
    }

    /**
     * @throws RateLimitExceededException
     * @throws UnauthenticatedException
     * @throws DomainwardenException
     * @throws SubscriptionRequiredException
     */
    protected function request(string $method, string $endpoint, array $data = []): Response
    {
        $response = Http::withToken($this->apiToken)
            ->$method("{$this->apiUrl}/{$endpoint}", $data);

        $this->handleErrors($response);

        return $response;
    }

    /**
     * @throws RateLimitExceededException
     * @throws UnauthenticatedException
     * @throws DomainwardenException
     * @throws SubscriptionRequiredException
     */
    protected function handleErrors(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        match ($response->status()) {
            401 => throw UnauthenticatedException::invalidToken(),
            402 => throw new SubscriptionRequiredException(
                $response->json('message', 'An active subscription is required to access this feature.')
            ),
            404 => throw new NotFoundException($response->json('message', 'Resource not found.')),
            422 => throw new ValidationException(
                $response->json('message', 'Validation failed.'),
                $response->json('errors', [])
            ),
            429 => throw new RateLimitExceededException(
                $response->json('message', 'Too many requests. Please slow down.'),
                $response->json('retry_after')
            ),
            default => throw new DomainwardenException(
                $response->json('message', 'An error occurred.'),
                $response->status()
            ),
        };
    }
}
