<?php namespace Gufran\AuthNet\Entities\RequestObjects;


class CreateTransactionRequest extends BaseObject {

    protected $methods = array(
        'amount' => 'profileTransCaptureOnly.amount',
        'cardCode' => 'profileTransCaptureOnly.cardCode',
        'approvalCode' => 'profileTransCaptureOnly.approvalCode',
        'splitTenderId' => 'profileTransCaptureOnly.splitTenderId',
        'lineItemsName' => 'profileTransCaptureOnly.lineItems.name',
        'recurringBilling' => 'profileTransCaptureOnly.recurringBilling',
        'lineItemsItemId' => 'profileTransCaptureOnly.lineItems.itemId',
        'lineItemsTaxable' => 'profileTransCaptureOnly.lineItems.taxable',
        'orderDescription' => 'profileTransCaptureOnly.order.description',
        'customerProfileId' => 'profileTransCaptureOnly.customerProfileId',
        'lineItemsQuantity' => 'profileTransCaptureOnly.lineItems.quantity',
        'orderInvoiceNumber' => 'profileTransCaptureOnly.order.invoiceNumber',
        'lineItemsUnitPrice' => 'profileTransCaptureOnly.lineItems.unitPrice',
        'lineItemsDescription' => 'profileTransCaptureOnly.lineItems.description',
        'customerPaymentProfileId' => 'profileTransCaptureOnly.customerPaymentProfileId',
        'orderPurchaseOrderNumber' => 'profileTransCaptureOnly.order.purchaseOrderNumber'
    );

    /**
     * check if the Object respond to a certain type of request method
     *
     * @param $methodName
     *
     * @return boolean
     */
    public function respondTo($methodName)
    {
        return $methodName == 'CreateProfileTransaction';
    }
}