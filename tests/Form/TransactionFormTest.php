<?php


namespace App\Tests\Form;


use App\Document\Transaction;
use App\Form\TransactionType;
use App\Tests\TypeTestCase;

class TransactionFormTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = $this->formData();
        $transaction = new Transaction();
        $form = $this->factory->create( TransactionType::class, $transaction);
        $form->submit($formData);

        $expected = $this->getTransaction();

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $transaction);
    }

    public function testFormView()
    {
        $transaction = $this->getTransaction();
        $view = $this->factory->create(TransactionType::class, $transaction)
            ->createView();
        $this->assertArrayHasKey('data', $view->vars);
        /** @var Transaction $transactionView */
        $transactionView = $view->vars['data'];
        $this->assertEquals($transactionView, $transaction);
    }
}