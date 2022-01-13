<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CheckoutNewsletterSubscription\Observer;

use Exception;
use GhostUnicorns\CheckoutNewsletterSubscription\Model\Data\NewsletterSubscription as NewsletterSubscriptionData;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Newsletter\Model\SubscriptionManager;
use Magento\Quote\Model\Quote;
use Psr\Log\LoggerInterface;

class NewsletterSubscription implements ObserverInterface
{
    /**
     * @var SubscriptionManager
     */
    private $subscriptionManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param SubscriptionManager $subscriptionManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        SubscriptionManager $subscriptionManager,
        LoggerInterface $logger
    ) {
        $this->subscriptionManager = $subscriptionManager;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var $quote Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        $storeId = (int)$quote->getStoreId();
        $customerEmail = $quote->getCustomerEmail();
        $customerId = (int)$quote->getCustomerId();
        $quoteSuscriptionValue = (bool)$quote->getData(
            NewsletterSubscriptionData::NEWSLETTER_SUBSCRIPTION
        );
        if ($quote->getCustomerEmail()
            && $quoteSuscriptionValue
        ) {
            try {
                $this->subscriptionManager->subscribe($customerEmail, $storeId);
                $this->subscriptionManager->subscribeCustomer($customerId, $storeId);
            } catch (Exception $e) {
                $this->logger->error("Error in GhostUnicorns/NewsletterSubscription observer:" . $e->getMessage());
            }
        }
    }
}
