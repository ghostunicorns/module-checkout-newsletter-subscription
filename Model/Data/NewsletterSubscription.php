<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CheckoutNewsletterSubscription\Model\Data;

use GhostUnicorns\CheckoutNewsletterSubscription\Api\Data\NewsletterSubscriptionInterface;
use Magento\Framework\Api\AbstractSimpleObject;

class NewsletterSubscription extends AbstractSimpleObject implements NewsletterSubscriptionInterface
{
    const NEWSLETTER_SUBSCRIPTION = 'newsletter_subscription';

    /**
     * @param string $subscribe
     * @return null
     */
    public function setSubscribe($subscribe)
    {
        return $this->setData(static::NEWSLETTER_SUBSCRIPTION, $subscribe);
    }

    /**
     * @return string
     */
    public function getSubscribe()
    {
        return $this->_get(static::NEWSLETTER_SUBSCRIPTION);
    }
}
