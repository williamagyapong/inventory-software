<?php 

class Product extends Model
{

	public function create()
{
	$name        = $_POST['name'];
	$cost        = $_POST['cost'];
	$price       = $_POST['price'];
	$quantity    = $_POST['quantity'];
	$date        = date('Y-m-d');  
    
	if( !empty($name)&&
		!empty($cost)&&
		!empty($price)&&
		!($quantity=="")
		){

		$itemInStock = $this->_db->select("SELECT name, price FROM products WHERE name = '{$name}' AND price = '{$price}'")->results();
	    
	     if(count($itemInStock)>0)
	     {
	     	 echo "<h2>Item already in stock</h2>";
	     } else{

	     	  //insert data with insert functon(functions/db-helper)
			if($this->_db->insert('products',[
				    'name'=>ucwords($name),
				    'cost'=>$cost,
				    'price'=>$price,
				    'quantity'=>$quantity,
				    'date_created'=>$date

				])){
				echo "<h2>Stock successfully created</h2>";
			}
			else{
				echo "<h2 style='color:red'>Sorry, could not create product!</h2>";
			}
	     }
		

	}
	else{
		echo "<h2 style='color:red'>All fields are required</h2>";
	}
}

public function add()
{
	
	
	$quantity    = $_POST['quantity'];
	$prodId      = $_POST['id'];

	if(!empty($prodId)&&!empty($quantity)){

	 $itemInStock = $this->_db->select("SELECT * FROM products WHERE id = '{$prodId}'")->first();
		//print_array($itemInStock); die();
	    $qty = $itemInStock->quantity + $quantity;

		
		if($this->_db->update('products', [

			      'quantity'=>$qty], $itemInStock->id
			      )){
			echo "<h2>Product updated</h2>";
		}
		else{
			echo "<h2 style='color:red'>Sorry, could not update product!</h2>";
		}

	}
	else{
		echo "<h2 style='color:red'>All fields are required</h2>";
	}
}

public function get($id="*")
{
	if($id=="*"){
		//select all products
      return $this->_db->select("SELECT * FROM `products` ORDER BY `name` ASC")->results();
	}
	else{
		//select a particular product
		return $this->_db->select("SELECT * FROM `products` WHERE `id`='$id'")->first();
	}
}



public function update()
{
	$name        = $_POST['name'];
	$cost        = $_POST['cost'];
	$price       = $_POST['price'];
	$prodId      = $_POST['prod-id'];
	$quantity    = $_POST['quantity'];
	$date        = $_POST['date'];

	// use update function(core/functions/db-helper.php)
	if($this->_db->update2('products', ['id'=>$prodId], [
		       'name'=>$name,
		       'cost'=>$cost,
		       'price'=>$price,
		       'quantity'=>$quantity,
		       'date_created'=>$date
		])){
		//echo "<h2 class='h2'>Changes saved</h2>";
		return true;
	}
	else{
		//echo "<h2 style='color:red'>Sorry, unable to  save changes</h2>";
		return false;
	}
}


public function delete()
{
	 $prodId      = $_POST['prod-id'];
	 $itemSold   = $this->_db->select("SELECT id FROM sales WHERE product_id = '{$prodId}'")->first();
	 if(count($itemSold)>0) {
	 	return false;
	 } else {

	 	 if($this->_db->delete('products', ['id','=',$prodId])) {
		 	return true;
		 } else{
		 	return false;
		 }
	 }
	 
}


public function allowSale($qtyBought, $prodId)
{
	$stock = $this->get($prodId);
	
	if($stock->quantity>=$qtyBought) {
		return true;
	} else{
		return false;
	}
   /*if($_SESSION['qty-in-stock'] >= $qtyBought) {
   	  return true;
   }*/
}


public function trackSales(array $sales)
{
   if(isset($_SESSION['sales'])) {
      //add to existing sales
   	  array_push($_SESSION['sales'], $sales);
   } else{
   	//create new sales session variable
   	 $_SESSION['sales'] = array();
   	 array_push($_SESSION['sales'], $sales);
   }
}


public function makeSales()
{ 
   $name     = $_POST['name'];
   $cp       = $_POST['cost'];//unit  cost price
   $price    = $_POST['price'];//unit selling price
   $qtyBought = $_POST['quantity'];

   if(isset($_SESSION['prod-id'])/*&&isset($_SESSION['qty-in-stock'])*/){

   	       $prodId   = $_SESSION['prod-id'];
		   $sellerId  = Session::get('user');
		   

		   
		   //calculate the cost of the products being sold 
		   $purchaseCost = $cp * $qtyBought;//purchase cost
		   $cost  = $price * $qtyBought;//cost of sale
		   
		   if($this->allowSale($qtyBought, $prodId))
		   {  
		       //reduce quantity available by quantity just sold
		   	   //$_SESSION['qty-in-stock'] = $_SESSION['qty-in-stock'] - $qtyBought;
               if($this->_db->update2('products', ['id'=>$prodId], ['quantity'=>$qtyBought],'-')&&
               	  $this->_db->update2('products',['id'=>$prodId], ['qty_sold'=>$qtyBought],'+')) {
               	 //return product sold info
               	 return  $salesInfo = array(
           	                         'prod_id'=>$prodId,
			   	 	                 'name'=>$name, 
			   	  	                 'price'=>$price,
			   	  	                 'cost'=>$cost,
			   	  	                 'purch_cost'=>$purchaseCost,
			   	  	                 'quantity'=>$qtyBought
			   	  	                 
			   	  	                 );
               } else {
               	// return empty array upon error
               	 return $salesInfo = array();
               }
		       

		   }else{
		   	      //return empty array upon error
		          return $salesInfo = array();
		   }

   	 }else{
		   	      //return empty array upon error
		          return $salesInfo = array();
		   }
		   
   
}




function salesApproved()
{
	$payment = $_POST['payment'];
	$salesCost= $_POST['sales-cost'];
    $balance = $payment - $salesCost;
	$_SESSION['payment'] = $payment;
    $_SESSION['Balance'] = $balance;
    $iterations = 0;

    if($payment<$salesCost && !isset($_POST['accept-credit-sale'])) 
    	return false;
    //else  update and insert sales data;
    if(isset($_SESSION['sales'])) {
    	foreach($_SESSION['sales'] as $sales) {

    		/*$product = displayProd($sales['prod_id']);
    		$qtyInStock = $product[0]['quantity'];
    		$qtyLeft  = $product[0]['quantity'] - $sales['quantity'];
    		$qtySold  = $product[0]['qty_sold'] + $sales['quantity'];
    		if(update('products',['id'=>$sales['prod_id']], [
			   	          'quantity'=>$qtyLeft,
			   	          'qty_sold'=>$qtySold     
			   	])) {*/
			   	 //store sales record in sales table
			   	 $date = date('Y-m-d');
			   	 $time = date('H:i:s');
			   	 $date2 = date("Y-m-d");
			   	 $sellerId  = Session::get('user');
                 //handle credit sales perculiarities
			   	 if(isset($_POST['accept-credit-sale'])) {
			   	 	 $customerName = ucwords($_POST['customer-name']);
			   	 	 $contact     = $_POST['contact'];
			   	 	 $debt = $salesCost-$payment;
			   	 	if($iterations ==0)
			   	 	 {
                        $this->_db->insert('customers', [
			    	       'name'=>$customerName,
			    	       'contact'=>$contact,
			    	       'product_id'=>$sales['prod_id'],
			    	       'seller_id'=>$sellerId,
			    	       'owing'=>$debt,
			    	       'paid'=>$payment,
			    	       'date'=>$date2
			    	        ]) ;
                      //get customer id
		              $_SESSION['customer-id']  = $this->_db->lastInsertedId();
		          }
					   	 $this->_db->insert('sales',[
					   	 	     'time'=>$time,
					   	 	     'purch_cost'=>$sales['purch_cost'],
					   	 	     'sale_cost'=>$sales['cost'],
					   	 	     'product_id'=>$sales['prod_id'],
					   	 	     'date_sold'=>$date,
					   	 	     'qty_bought'=>$sales['quantity'],
					   	 	     'seller_id'=>$sellerId,
					   	 	     'customer_id'=>$_SESSION['customer-id']
					   	 	]);
					   	  $iterations++;
			    	
           
			   	 } else{
			   	 	 $this->_db->insert('sales',[
			   	 	     'time'=>$time,
			   	 	     'purch_cost'=>$sales['purch_cost'],
			   	 	     'sale_cost'=>$sales['cost'],
			   	 	     'product_id'=>$sales['prod_id'],
			   	 	     'date_sold'=>$date,
			   	 	     'qty_bought'=>$sales['quantity'],
			   	 	     'seller_id'=>$sellerId
			   	 	]);
			   	  $iterations++;

			   	 }
			   	 
			   	  
			   /*}else{
			   	   return false;
			   } */

			   if($iterations==count($_SESSION['sales'])) {
			   	//set current sales to zero
			   	 foreach($_SESSION['sales'] as $sales) {
			   	 	$this->_db->update2('products', ['id'=>$sales['prod_id']], ['current_sale'=>0]);
			   	 }
			   	  return true;
			   }
    	}
    }
}


function cancelSales()
{
	if(isset($_SESSION['sales'])) {
		$sales = $_SESSION['sales'];
		$iterations = 0;
		foreach($sales as $sale) {
            $product = $this->get($sale['prod_id']);
    		$qtyInStock = $product->quantity;
    		//reverse sales transactions
    		$qtyLeft  = $product->quantity + $sale['quantity'];
    		$qtySold  = $product->qty_sold - $sale['quantity'];
			if($this->_db->update2('products',['id'=>$sale['prod_id']], [
			   	          'quantity'=>$qtyLeft,
			   	          'qty_sold'=>$qtySold     
			   	])) {
				$iterations++;
			}
			
		}
		if($iterations == count($_SESSION['sales'])){
			return true;
		}
	} else{
			die("Sorry, sales could not be cancelled.");
		}
}

public function search($name)
{  
	return $this->_db->select("SELECT * FROM `products` WHERE `name`LIKE'$name%'")->results();
}

public function getSales($from=null, $to=null)
{ 
	
	//$sellerId = $_SESSION['ADMINID'];
	if(!($from && $to)) {
		return $this->_db->select("SELECT products.*, sales.* FROM products, sales WHERE products.id = sales.product_id ORDER BY sales.date_sold DESC")->results();
	} else {
		
        
	     //selecting from the products and sales tables
         return $this->_db->select("SELECT products.*, sales.* FROM products, sales WHERE products.id = sales.product_id AND sales.date_sold BETWEEN '{$from}' AND '{$to}' ORDER BY sales.time")->results();
	}
	
}


/**
* filter sales records by criteria
*@return array
*@param 
*/
public function filterSales($term)
{ 
	
	//$sellerId = $_SESSION['ADMINID'];
	if($term)
	 {
		return $this->_db->select("SELECT products.*, sales.* FROM products, sales WHERE products.id = sales.product_id AND products.name LIKE '$term%' ORDER BY sales.date_sold DESC")->results();
	}
	
}


/**
*fetch stock data by date criteria
*@return
*@param
*/
public function getSalesByRange($from=null, $to=null, $prodId)
{

	if($from && $to) {
		//gurantee valid date format
		$date_format = new DateTime();
		$from = $date_format->format($from);
		$to   = $date_format->format($to);
	   if($prodId == "all") {
		 return $this->_db->select("SELECT * FROM `sales` WHERE `date_sold` BETWEEN '{$from}' AND '{$to}'")->results();
	   } else {

	   	   return $this->_db->select("SELECT * FROM `sales` WHERE `date_sold` BETWEEN '{$from}' AND '{$to}' AND `product_id`='{$prodId}'")->results();
	   }

	} else {
		echo "Please enter date"; die();
	}
}


public function getOutstanding($from=null, $to=null, $prodId)
{
     $outstanding = 0;
	 $data = [];
	if($from && $to) {
		//gurantee valid date format
		$date_format = new DateTime();
		$from = $date_format->format($from);
		$to   = $date_format->format($to);
		
	   if($prodId == "all") {
		   $data = $this->_db->select("SELECT * FROM `customers` WHERE `date` BETWEEN '{$from}' AND '{$to}' AND `owing` != 0")->results();
	   } else {

	   	   $data = $this->_db->select("SELECT * FROM `customers` WHERE `date` BETWEEN '{$from}' AND '{$to}' AND `owing` != 0 AND `product_id`='{$prodId}'")->results();
	   }

	} else {
		echo "Function requires date to be entered";die();
	}

	foreach($data as $outSale) {
		$outstanding += $outSale->owing;
	}

	return $outstanding;
}

//print_array(getStockInfo('07-01-2016', '2016-07-20')); die();

public function insertExpense()
{
	$description = $_POST['description'];
	$amount  = $_POST['amount'];
	$date = date("Y-m-d");
	if(is_numeric($amount)) {
		if($this->_db->insert('expenses',[
			      'description'=>ucwords($description),
			      'amount'=>$amount,
			      'date'=>$date
			])) {
			return true;
		}
	} else{
		return false;
	}
}



public function getExpense($from=null, $to=null)
{ 
	//gurantee valid date format
	    $expense = 0;
		$date_format = new DateTime();
		$from = $date_format->format($from);
		$to   = $date_format->format($to);
        $expenses =  $this->_db->select("SELECT * FROM `expenses` WHERE `date` BETWEEN '{$from}' AND '{$to}'")->results();
	foreach($expenses as $value) {
        $expense += $value->amount;
	}
	return $expense;
}

public function getExpenses()
{
	return $this->_db->select("SELECT * FROM `expenses`")->results();
}

 //echo (getExpense('2016-07-02', '2016-08-4'));die();


public function getExpectedSales()
{
	return $this->_db->select("SELECT * FROM `products`  ORDER BY `name`")->results();
}

function getSeller($id)
{   
	
	return select("SELECT * FROM `admin` WHERE `id`='$id'");
}


}