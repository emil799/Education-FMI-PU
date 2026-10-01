class Player extends GameObject {
  char direction;
  PImage image_right;
  int collectedCoins = 0;
  int killedEnemies = 0;
  
  // Ново поле за отбелязване на посоката на играча
  int shootingDirection = 1; // 1 - дясно, -1 - наляво
  
  Player(float _x, float _y, float _w, float _h) {
    super(_x, _y, _w, _h);
    image = loadImage("assets/mario.png");
    image_right = loadImage("assets/mario_right.png");
  }

  void Display() {
    if (direction == 'a') {
      image(image, x, y);
    } else {
      image(image_right, x, y);
    }
  }

  void Move(char code) {
    switch(code) {
    case 'a':
      player.x -= 5;
      direction = 'a';
      shootingDirection = -1; // Промяна на посоката наляво
      break;
    case 'd':
      player.x += 5;
      direction = 'd';
      shootingDirection = 1; // Промяна на посоката надясно
      break;
    case 'w':
      player.y -= 10;
      direction = 'w';
      break;
    case 's':
      player.y += 10;
      direction = 's';
      break;
    default:
      println("key pressed "+code);   // don't match the switch parameter
      break;
    }
  }
  void CollectCoin() {
    collectedCoins++;
    println("Collected coins: " + collectedCoins);
  }
  boolean CheckCollision(Coin coin) {
    if (x < coin.x + coin.w &&
        x + w > coin.x &&
        y < coin.y + coin.h &&
        y + h > coin.y) {
      return true;
    }
    return false;
  }
  void KilledEnemies(){
    killedEnemies++;
    println("Killed enemies: " + killedEnemies);
  }
  
  boolean CheckEnemies(Enemy enemy) {
    if (x < enemy.x + enemy.w &&
        x + w > enemy.x &&
        y < enemy.y + enemy.h &&
        y + h > enemy.y) {
      return true;
    }
    return false;
  }
}
