<?php

/**
 * @file
 * Contains \Drupal\omnipay\Tests\Plugin\Payment\Method\PaymentMethodBaseUnitTest.
 */

namespace Drupal\omnipay\Tests\Plugin\Payment\Method;

use Drupal\Tests\UnitTestCase;
use Omnipay\Common\GatewayInterface;

/**
 * @coversDefaultClass \Drupal\omnipay\Plugin\Payment\Method\PaymentMethodBase
 */
class PaymentMethodBaseUnitTest extends UnitTestCase {

  /**
   * @var \Omnipay\Common\GatewayInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $gateway;

  /**
   * The payment method under test.
   *
   * @var \Drupal\omnipay\Plugin\Payment\Method\PaymentMethodBase
   */
  protected $paymentMethod;

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'description' => '',
      'name' => '\Drupal\omnipay\Tests\Plugin\Payment\Method\PaymentMethodBase unit test',
      'group' => 'Omnipay',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->gateway = $this->getMock('\Omnipay\Common\GatewayInterface');

    $this->paymentMethod = $this->getMockBuilder('\Drupal\omnipay\Plugin\Payment\Method\PaymentMethodBase')
      ->disableOriginalConstructor()
      ->getMockForAbstractClass();
    $property = new \ReflectionProperty($this->paymentMethod, 'gateway');
    $property->setAccessible(TRUE);
    $property->setValue($this->paymentMethod, $this->gateway);
  }

  /**
   * @covers ::defaultConfiguration
   */
  public function testDefaultConfiguration() {
    $configuration = array(
      'foo' => $this->randomName(),
    );
    $this->gateway->expects($this->once())
      ->method('getDefaultParameters')
      ->will($this->returnValue($configuration));

    $this->assertSame($configuration, $this->paymentMethod->defaultConfiguration());
  }

}
