<?php

  class ShoppingCart {

    public $shoppingCart = [];
    public $subtotalPrice = 0;
    public $totalPrice = 0;

    function __construct(array $productsId, array $productsQuantities){

      $this->addProductsToShoppingCart($productsId, $productsQuantities);
      $this->setSubtotalPrice();
      $this->setTotalPrice();

    } 

    private function setSubtotalPrice(){
      foreach($this->shoppingCart as $product){
        $this->subtotalPrice += (float)$product['product']->price;
      }
    }

    private function setTotalPrice(){
      foreach($this->shoppingCart as $product){
        $price = (float)$product['product']->price * (int)$product['quantity'];
        $this->totalPrice += (float)$price;
      }
    }

    private function addProductsToShoppingCart(array $productsId, array $productsQuantities){

      foreach($productsId as $index => $id){

        $productDetails = Product::find_by_id($id);

        $this->shoppingCart[$index] = [
          'product' => $productDetails,
          'quantity' => $productsQuantities[$index],
        ];

      }

    }

  }


