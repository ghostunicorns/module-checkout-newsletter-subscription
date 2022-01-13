<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CheckoutNewsletterSubscription\Api;

use GhostUnicorns\CheckoutNewsletterSubscription\Api\Data\NewsletterSubscriptionInterface;

/**
 * Interface to set the newsletter subscription for logged in users
 * @api
 */
interface NewsletterSubscriptionManagementInterface
{
    /**
     * @param string $cartId
     * @param NewsletterSubscriptionInterface $newsletterSubscription
     * @return void
     */
    public function subscribe($cartId, NewsletterSubscriptionInterface $newsletterSubscription);
}
