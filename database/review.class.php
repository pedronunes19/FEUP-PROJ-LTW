<?php
  declare(strict_types = 1);

  class Review {
    public int $id;
    public int $score;
    public string $content;
    public int $customer;
    public int $restaurant;

    public function __construct(int $id, int $score, string $content, int $customer, int $restaurant)
    {
      $this->id = $id;
      $this->score = $score;
      $this->content = $content;
      $this->customer = $customer;
      $this->restaurant = $restaurant;
      
    }

  
  }
?>