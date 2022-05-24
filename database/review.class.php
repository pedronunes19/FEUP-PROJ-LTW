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

    static function getReviews(PDO $db, int $restaurant) : array {
      $stmt = $db->prepare('SELECT ReviewId, ReviewScore, ReviewContent, CustomerId, RestaurantId FROM Review WHERE RestaurantId = ?');
      $stmt-> execute(array($restaurant));

      $reviews = array();
      while ($review = $stmt->fetch()) {
        $reviews[] = new Review($review['ReviewId'], $review['ReviewScore'], $review['ReviewContent'], $review['CustomerId'], $review['RestaurantId']);
      }
      return $reviews;
    }
  
  }
?>