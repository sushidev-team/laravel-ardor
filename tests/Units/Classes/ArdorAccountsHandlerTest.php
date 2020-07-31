<?php

namespace AMBERSIVE\Tests\Unit\Classes;

use AMBERSIVE\Tests\TestArdorCase;
use AMBERSIVE\Ardor\Classes\ArdorAccountsHandler;
use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Validation;

use Carbon\Carbon;

class ArdorAccountsTest extends TestArdorCase
{

    public function testGetAccountShouldReturnAccountData():void {

        $response = new ArdorMockResponse(200, ['effectiveBalanceFXT' => 878]);

        $ardor = new ArdorAccountsHandler();

        $account = $ardor->setClient($this->createApiMock([$response]))->getAccount(config('ardor.wallet'), ['includeEffectiveBalance' => "true"]);

        $this->assertNotNull($account);
        $this->assertEquals(878, $account->effectiveBalanceFXT);

    }

    /**
     * Test the Methods getAccountCurrencies will return a valid object
     */
    public function testGetAccountCurrencies():void {

        $response = new ArdorMockResponse(200, ['accountCurrencies' => []]);

        $ardor = new ArdorAccountsHandler();
        $accountData = $ardor
                        ->setClient($this->createApiMock([$response]))
                        ->getAccountCurrencies(config('ardor.wallet'), []);

        $this->assertNotNull($accountData);
        $this->assertTrue(is_array($accountData->accountCurrencies));
        $this->assertTrue($accountData instanceof \AMBERSIVE\Ardor\Models\ArdorAccountCurrencies);

    }

    /**
     * Test if the balance from an account can be gettet
     */
    public function testIfArdorGetBalanceReturnsTheBalance(): void {

        $ardor = new ArdorAccountsHandler();
        $accountData = $ardor
                        ->getBalance(config('ardor.wallet'), 1, []);

       $this->assertNotNull($accountData);
       $this->assertNotEquals(0, $accountData->unconfirmedBalanceNQT);
       $this->assertNotEquals(0, $accountData->balanceNQT);
        
    }

}