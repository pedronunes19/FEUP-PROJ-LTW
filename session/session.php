<?php
  class Session {
    private array $messages;
    public array $items;

    public function __construct() { 
      session_set_cookie_params(0, '../pages/', true, true);
      session_start();

      $this->items = isset($_SESSION['items']) ? $_SESSION['items'] : array();
      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }

    public function getName() : ?string {
      return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function getType() : ?string {
      return isset($_SESSION['type']) ? $_SESSION['type'] : null;
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setName(string $name) {
      $_SESSION['name'] = $name;
    }

    public function setType(string $type) {
      $_SESSION['type'] = $type;
    }

    public function addToCart(string $type, int $id, int $amount, int $restaurant) {
      $_SESSION['items'][] = array('type' => $type, 'id' => $id, 'amount' => $amount, 'restaurant' => $restaurant);
    }

    public function incrementAmount(int $index, int $amount){
      $_SESSION['items'][$index]['amount'] += $amount;
    }

    public function removeFromCart(string $type, int $id) {
      foreach ($_SESSION['items'] as $item) {
        if (($item['type'] == $type) && ($item['id'] == $id)) {
          $index = array_search($item, $_SESSION['items']);
          array_splice($_SESSION['items'], $index, 1);
        }
      }
    }

    public function resetCart() {
      $_SESSION['items'] = array();
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }

    public function getItems() {
      return $this->items;
    }
  }
?>