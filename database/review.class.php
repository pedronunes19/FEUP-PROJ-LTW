<?php
  declare(strict_types = 1);

  class Review {
    public int $id;
    public int $score;
    public string $content;
    public ?string $response;
    public int $customer;
    public int $restaurant;

    public function __construct(int $id, int $score, string $content, ?string $response, int $customer, int $restaurant)
    {
      $this->id = $id;
      $this->score = $score;
      $this->content = $content;
      $this->customer = $customer;
      $this->response = $response;
      $this->restaurant = $restaurant;
    }

    function save($db, int $score, string $content, ?string $response, int $id) {
      $stmt = $db->prepare('
        UPDATE Review SET ReviewScore = ?, ReviewContent = ?, ReviewResponse = ?
        WHERE ReviewId = ?
      ');

      $stmt->execute(array($score, $content, $response, $id));
    }

    static function create($db, int $score, string $content, int $customer_id, int $restaurant_id) {
      $stmt = $db->prepare('
        INSERT INTO Review (ReviewId, ReviewScore, ReviewContent, CustomerId, RestaurantId)  
        VALUES (NULL, ?, ?, ?, ?)'
      );
      $stmt->execute(array($score, $content, $customer_id, $restaurant_id));
    }

    static function deleteReview(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE FROM Review WHERE ReviewId = ?
      ');
      $stmt->execute(array($id));
  
      return;
    }

    static function getReview(PDO $db, int $review_id) : Review {
      $stmt = $db->prepare('SELECT ReviewId, ReviewScore, ReviewContent, ReviewResponse, CustomerId, RestaurantId FROM Review WHERE ReviewId = ?');
      $stmt-> execute(array($review_id));

      $review = $stmt->fetch();
      return new Review($review['ReviewId'], $review['ReviewScore'], $review['ReviewContent'], $review['ReviewResponse'], $review['CustomerId'], $review['RestaurantId']);
    }

    static function getReviews(PDO $db, int $restaurant_id) : array {
      $stmt = $db->prepare('SELECT ReviewId, ReviewScore, ReviewContent, ReviewResponse, CustomerId, RestaurantId FROM Review WHERE RestaurantId = ?');
      $stmt-> execute(array($restaurant_id));

      $reviews = array();
      while ($review = $stmt->fetch()) {
        $reviews[] = new Review($review['ReviewId'], $review['ReviewScore'], $review['ReviewContent'], $review['ReviewResponse'], $review['CustomerId'], $review['RestaurantId']);
      }
      return $reviews;
    }

    static function getReviewsByUser(PDO $db, int $id) : array {
      $stmt = $db->prepare('SELECT ReviewId, ReviewScore, ReviewContent, ReviewResponse, CustomerId, RestaurantId FROM Review WHERE CustomerId = ?');
      $stmt-> execute(array($id));

      $reviews = array();
      while ($review = $stmt->fetch()) {
        $reviews[] = new Review($review['ReviewId'], $review['ReviewScore'], $review['ReviewContent'], $review['ReviewResponse'], $review['CustomerId'], $review['RestaurantId']);
      }
      return $reviews;
    }
  }
?>