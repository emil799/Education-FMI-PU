class Coin extends GameObject {
  Coin(float _x, float _y, float _w, float _h) {
    super(_x, _y, _w, _h);
    image = loadImage("assets/coin.png");
    image.resize(30, 30);
  }

  void Display() {
    if (is_visible) {
      image(image, x, y);
      CheckCollection();
    }
  }

  // Логика за събиране на монети
  void CheckCollection() {
    if (player != null && player.CheckCollision(this)) {
      is_visible = false; // Събиране на монетата
      player.CollectCoin();
      
      // Генериране на нови координати за монетата
      float newX = random(width - w);
      float newY = random(height - h);
      respawn(newX, newY);
    }
}

// Метод за респаун на монетата
  void respawn(float newX, float newY) {
    x = newX;
    y = newY;
    is_visible = true;
  }

}
