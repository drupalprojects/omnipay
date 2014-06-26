<?php

/**
 * @file
 * Contains \Drupal\omnipay\Plugin\Payment\Method\AbstractPaymentMethodBase.
 */

namespace Drupal\omnipay\Plugin\Payment\Method;

use Drupal\payment\Entity\PaymentInterface;

/**
 * Provides a basis for payment methods that use \Omnipay\Common\AbstractGateway gateways.
 */
abstract class AbstractPaymentMethodBase extends PaymentMethodBase {

  /**
   * {@inheritdoc}
   */
  public function setPayment(PaymentInterface $payment) {
    parent::setPayment($payment);
    $this->gateway->setCurrency($payment->getCurrencyCode());
  }

}

