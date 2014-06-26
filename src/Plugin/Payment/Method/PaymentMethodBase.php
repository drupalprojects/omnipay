<?php

/**
 * @file
 * Contains \Drupal\omnipay\Plugin\Payment\Method\PaymentMethodBase.
 */

namespace Drupal\omnipay\Plugin\Payment\Method;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Utility\Token;
use Drupal\payment\Plugin\Payment\Method\PaymentMethodBase as GenericPaymentMethodBase;
use Omnipay\Common\GatewayFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Provides a basis for payment methods that use Omnipay gateways.
 */
abstract class PaymentMethodBase extends GenericPaymentMethodBase {

  /**
   * @var \Omnipay\Common\GatewayInterface
   */
  protected $gateway;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return $this->gateway->getDefaultParameters();
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->gateway->getParameters();
  }

  /**
   * {@inheritdoc}
   */
  public function doExecutePayment() {
    return $this->gateway->purchase($this->getConfiguration());
  }

}

