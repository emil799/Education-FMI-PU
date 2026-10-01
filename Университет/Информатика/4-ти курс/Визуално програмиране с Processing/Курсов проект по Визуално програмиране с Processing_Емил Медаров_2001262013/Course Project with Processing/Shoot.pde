class Shoot extends GameObject {
  float speed;
  color shootColor;

  Shoot(float _x, float _y, float _w, float _h, color _shootColor, float _speed) {
    super(_x, _y, _w, _h);
    speed = _speed;
    shootColor = _shootColor;
  }

  void Display() {
    fill(shootColor);
    ellipse(x, y, w, h);
  }

  void Move() {
    x += speed;
  }

  boolean CheckCollision(Enemy enemy) {
    if (x < enemy.x + enemy.w &&
        x + w > enemy.x &&
        y < enemy.y + enemy.h &&
        y + h > enemy.y) {
      return true;
    }
    return false;
  }
}
