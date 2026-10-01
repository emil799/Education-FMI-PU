class Enemy extends GameObject {
  
  Enemy(float _x, float _y, float _w, float _h) {
    super(_x, _y, _w, _h);
    image = loadImage("assets/enemy.png");
    image.resize(50, 50);
  }

  void Display() {
    if (is_visible) {
      image(image, x, y);
    }
  }
  
  void Move() {
  if (x < width - w) {
    x += 2; // движение надясно
  } else {
    respawn();
  }
}

// Метод за респаун на врага
  void respawn() {
    x = 0 - w;
    y = random(height - h);
    is_visible = true;  
  }

}
