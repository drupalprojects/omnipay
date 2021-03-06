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
use Omnipay\Common\Message\RedirectResponseInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Provides a basis for payment methods that use Omnipay gateways.
 */
abstract class PaymentMethodBase extends GenericPaymentMethodBase {

  /**
   * The wrapped Omnipay gateway.
   *
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
  public function setConfiguration(array $configuration) {
    $this->gateway->initialize($configuration);
  }

  /**
   * {@inheritdoc}
   */
  public function doExecutePayment() {
    $request =  $this->gateway->purchase($this->getConfiguration());
    $response = $request->send();
    $this->setConfiguration($this->gateway->getParameters());
    $this->getPayment()->save();
    if ($response->isRedirect() && $response instanceof RedirectResponseInterface) {
      $response->redirect();
    }
    else {
      $this->getPayment()->getPaymentType()->resumeContext();
    }
  }

}

