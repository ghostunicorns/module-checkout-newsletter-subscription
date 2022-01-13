<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CheckoutNewsletterSubscription\Api\Data;

interface NewsletterSubscriptionInterface
{
    /**
     * @param string $subscribe
     * @return null
     */
    public function setSubscribe($subscribe);

    /**
     * @return string
     */
    public function getSubscribe();
}
