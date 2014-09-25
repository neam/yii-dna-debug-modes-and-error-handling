<?php

$I = new WebGuy($scenario);
$I->wantTo('verify that errors are shown in a user-friendly manner');

$I->amOnPage(TriggerErrorPage::route('notice=1'));
$I->dontSee('Stack Trace', 'div.traces');
$I->seeElement(TriggerErrorPage::$backToHome);

$I->amOnPage(TriggerErrorPage::route('warning=1'));
$I->dontSee('Stack Trace', 'div.traces');
$I->seeElement(TriggerErrorPage::$backToHome);

$I->amOnPage(TriggerErrorPage::route('fatal=1'));
$I->dontSee('Stack Trace', 'div.traces');
$I->seeElement(TriggerErrorPage::$backToHome);
