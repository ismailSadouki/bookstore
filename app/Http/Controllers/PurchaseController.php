<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use PayPal\Api\PaymentExecution;

class PurchaseController extends Controller
{
    public function createPayment(Request $request) 
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AdQUFPr9lEQEdrj6zA-9j2ahk134Cy7-ySvYlQyvc6ameVYGlGWhCpffQ4_ZW_frzG9V9OHKLMC30nYX', 
                'EEfh-5soPtXznj3c9vkIbw2zydB0M72AKR3F87JCxfCdCe4IvavQB4SW9PgXG7MdrbVJ_ZSveDCGeKfJ')
        );

        $shipping = 0;
        $tax = 0;
    
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
    
        $books = User::find($request->userId)->booksInCart;
        $itemsArray = array();
        $total = 0;
        foreach($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
            
            $item = new Item();
            $item->setName($book->title)
            ->setCurrency('USD')
            ->setQuantity($book->pivot->number_of_copies)
            ->setSku($book->id) // Similar to `item_number` in Classic API
            ->setPrice($book->price);
            
            array_push($itemsArray, $item);
        }

        $itemList = new ItemList();
        $itemList->setItems($itemsArray);
    
        $details = new Details();
        $details->setShipping($shipping)
            ->setTax($tax)
            ->setSubtotal($total);
    
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total + $tax + $shipping)
            ->setDetails($details);
    
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
    
        $baseUrl = url('/');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$baseUrl/cart")
            ->setCancelUrl("$baseUrl/cart");
    
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
    
        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
            echo $ex;
            exit(1);
        }
        $approvalUrl = $payment->getApprovalLink();
        return $payment; 
    }

    public function executePayment(Request $request)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AdQUFPr9lEQEdrj6zA-9j2ahk134Cy7-ySvYlQyvc6ameVYGlGWhCpffQ4_ZW_frzG9V9OHKLMC30nYX', 
                'EEfh-5soPtXznj3c9vkIbw2zydB0M72AKR3F87JCxfCdCe4IvavQB4SW9PgXG7MdrbVJ_ZSveDCGeKfJ')
        );
    
        $paymentId = $request->paymentID;
        $payment = Payment::get($paymentId, $apiContext);
    
        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->payerID);
        
        
        try {
            $result = $payment->execute($execution, $apiContext);  
            $user = User::find($request->userId);
            $books = $user->booksInCart;
            foreach($books as $book) {
                $user->booksInCart()->updateExistingPivot($book->id, ['bought' => TRUE]);
                $book->save();
            }          
        } catch (Exception $ex) {
            echo $ex;
        }
    
        return $result;
    }


    public function viewOrder()
    {
        $order = DB::table('book_user')
                        ->join('users','book_user.user_id','users.id')
                        ->join('books','book_user.book_id','books.id')
                        ->select('book_user.*','users.name','books.price')    
                        ->where('bought' ,'!=', 0 )
                        ->get();
        // dd($order);
        return view('admin.order.index',compact('order'));
    }

    public function acceptOrder($id)
    {
        DB::table('book_user')->where('id',$id)->update(['bought' => 2]);
        $notification=array(
            'messege'=>'تم الموافقة على الطلبية',
            'alert-type'=>'success'
            );
        return Redirect()->back()->with($notification);	

    }
    public function cancelOrder($id)
    {
        DB::table('book_user')->where('id',$id)->update(['bought' => 3]);
        $notification=array(
            'messege'=>'تم الغاء الطلبية',
            'alert-type'=>'success'
            );
        return Redirect()->back()->with($notification);	
    }
}
