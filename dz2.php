<?php

class Product {
    public ?string $name;
    public ?int $price;

    public function __construct(?string $name,?int $price) {
        $this->name = $name;
        $this->price = $price;
    }
}

class Basket {
    private ?array $products = [];

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function calculateTotal() :int
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price;
        }
        return $total;
    }


    public function getProducts() : array
    {
        return $this->products;
    }

    public function removeProduct(Product $productToRemove) : void
    {
        $this->products = array_filter($this->products, function ($product) use ($productToRemove) {
            return $product !== $productToRemove;
        });
    }



    public function clearBasket(): void
    {
        $this->products = [];
    }




}




$product1 = new Product("Apple", 100);
$product2 = new Product("Banana", 150);
$product3 = new Product("Orange", 175);



$basket = new Basket();

$basket->addProduct($product1);
$basket->addProduct($product2);
$basket->addProduct($product3);



$totalCost = $basket->calculateTotal();
echo "Total cost: $" . $totalCost . "\n";




$products = $basket->getProducts();

echo "\nProducts in the basket:\n";
foreach ($products as $product) {
    echo $product->name . " - $" . $product->price . "\n";
}



$basket->removeProduct($product2);
$totalCost = $basket->calculateTotal();
echo "\nTotal cost after removing Banana: $" . $totalCost . "\n";



$basket->clearBasket();
echo "\nBasket cleared. Total cost: $" . $basket->calculateTotal() . "\n";

