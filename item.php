<?php
  session_start();
// list of products in an array
  $products = [
    [ "name" => "Sledgehammer", "price" => 125.75 ],
    [ "name" => "Axe", "price" => 190.50 ],
    [ "name" => "Bandsaw", "price" => 562.131 ],
    [ "name" => "Chisel", "price" => 12.9 ],
    [ "name" => "Hacksaw", "price" => 18.45 ],
  ];
// loop for buttons to add to cart / remove from cart
// increments / decrements quantity of product
  for($i=0; $i < count($products); $i++) {
    $num = "id$i";
    if(isset($_POST[$num])) {
      ++$_SESSION[$num];
    }
    $reset = "reset$i";
    if(isset($_POST[$reset])) {
      $_SESSION[$num] = 0;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Shop</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>SHOP</h1>
    <?php
// create objects 'item' from 'products' array
    class item {
      var $quantity;
      var $price;

// construct 'item' object with id, price & quantity
      function __construct($i, $price, $quantity){
        $this->id = "id$i";
        $this->price = $price;
        $this->quantity = $quantity;
      }
    }

// loop through the 'products' array, add each into a table listing name, price, add to cart button
    $cart = array();
    for($i = 0; $i < count($products); $i++) {
      $name = $products[$i]["name"];
      $price = number_format((float)$products[$i]['price'], 2, '.', '');
// placeholder for images to be added in future
      echo "<div class='column'><div class='row'><img src='' alt='Image of $name' /></div><br>";
      echo "<div class='row name'>$name</div>";
      echo "<div class='row'>\$$price</div>";
      echo "<div class='row'><form method='POST'><input type='submit' name='id$i' value='Add to cart' /></div></div></form>";
// create 'item' objects from products array and push those added to cart into $cart array
      $num = "id$i";
      $quantity = "$_SESSION[$num]";
      $$name = new item($i, $price, $quantity);
      array_push($cart, $name);
    }
    ?>
<!-- table of items added to cart -->
    <table>
      <caption>Shopping Cart</caption>
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th></th>
      </tr>
      <?php
// loop through $cart array and add each item to the cart table
        $absTotal = number_format((float)0, 2, '.', '');
        for($j=0; $j<count($cart); $j++) {
          $num = "id$j";
          if($_SESSION[$num] != 0) {
            $cur = $cart[$j];
            $price = $$cur->price;
            $total = number_format((float)$price*$_SESSION[$num], 2, '.', '');
            $absTotal += $total;
            $absTotal = number_format((float)$absTotal, 2, '.', '');
            print "<tr><td class='cartProduct'>$cur</td>";
            print "<td>$$price</td>";
            print "<td class='cartQty'>$_SESSION[$num]</td>";
            print "<td>$$total</td>";
            print "<td><form method='POST'><input type='submit' name='reset$j' value='x Remove' /></form></td></tr>";
          }
        }
        print "<tr class='cartTotalRow'><td></td><td></td><td></td><td>$$absTotal</td><td></td></tr>";
      ?>
    </table>

<!-- JS to prevent php form resubmission on page refresh -->
    <script>
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
      }
    </script>

  </body>
</html>
