<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When I fill :arg1 with :arg2
     */
    public function iFillWith($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When I fill :arg1 with "password
     */
    public function iFillWithPassword($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given I wait for the :arg1 to appear
     */
    public function iWaitForTheToAppear($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given I wait for the Log in to appear
     */
    public function iWaitForTheLogInToAppear()
    {
        throw new PendingException();
    }
}
