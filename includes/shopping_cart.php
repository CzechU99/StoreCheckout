<?php

  class ShoppingCart {

    public $shoppingCart = [];
    private $subtotalPrice = 0;
    private $totalPrice = 0;
    public $shoppingCartJson;

    function __construct(array $productsId, array $productsQuantities){

      $this->addProductsToShoppingCart($productsId, $productsQuantities);
      $this->setSubtotalPrice();
      $this->setTotalPrice();
      $this->shoppingCartJson = json_encode($this->shoppingCart);

    } 

    public function getTotalPrice(){
      if(floor($this->totalPrice) == $this->totalPrice) {
        return $this->totalPrice .= ',00';
      }else {
        return str_replace('.', ',', $this->totalPrice);
      }
    }

    public function getSubtotalPrice(){
      if(floor($this->subtotalPrice) == $this->subtotalPrice) {
        return $this->subtotalPrice .= ',00';
      }else {
        return str_replace('.', ',', $this->subtotalPrice);
      }
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

        $product = new Product();
        $productDetails = $product->find_by_id($id);

        $this->shoppingCart[$index] = [
          'product' => $productDetails,
          'quantity' => $productsQuantities[$index],
        ];

      }

    }

  }


