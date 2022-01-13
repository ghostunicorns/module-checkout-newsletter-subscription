<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CheckoutNewsletterSubscription\Model;

use Exception;
use GhostUnicorns\CheckoutNewsletterSubscription\Api\Data\NewsletterSubscriptionInterface;
use GhostUnicorns\CheckoutNewsletterSubscription\Api\NewsletterSubscriptionManagementInterface;
use GhostUnicorns\CheckoutNewsletterSubscription\Model\Data\NewsletterSubscription;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Model\ResourceModel\Quote\QuoteIdMask;

class NewsletterSubscriptionManagement implements NewsletterSubscriptionManagementInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;
    /**
     * @var QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;
    /**
     * @var QuoteIdMask
     */
    private $quoteIdMaskResourceModel;

    /**
     * @param QuoteIdMask $quoteIdMaskResourceModel
     * @param CartRepositoryInterface $cartRepository
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     */
    public function __construct(
        QuoteIdMask $quoteIdMaskResourceModel,
        CartRepositoryInterface $cartRepository,
        QuoteIdMaskFactory $quoteIdMaskFactory
    ) {
        $this->cartRepository = $cartRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->quoteIdMaskResourceModel = $quoteIdMaskResourceModel;
    }

    /**
     * @param string $cartId
     * @param NewsletterSubscriptionInterface $newsletterSubscription
     * @return void
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function subscribe($cartId, NewsletterSubscriptionInterface $newsletterSubscription)
    {
        if ((bool)$newsletterSubscription->getSubscribe()) {
            $quote = $this->getQuoteByCardId($cartId);

            try {
                $quote->setData(NewsletterSubscription::NEWSLETTER_SUBSCRIPTION, 1);
                $this->cartRepository->save($quote);
            } catch (Exception $e) {
                throw new CouldNotSaveException(__('The order comment could not be saved'));
            }
        }
    }

    /**
     * @param $cartId
     * @return CartInterface
     * @throws NoSuchEntityException
     */
    private function getQuoteByCardId($cartId)
    {
        try {
            return $this->cartRepository->getActive($cartId);
        } catch (Exception $e) {
            $quoteIdMask = $this->quoteIdMaskFactory->create();
            $this->quoteIdMaskResourceModel->load($quoteIdMask, $cartId, 'masked_id');
            return $this->cartRepository->getActive($quoteIdMask->getQuoteId());
        }
    }
}
