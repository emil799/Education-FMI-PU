Player player;
Terrain platform1;
Terrain platform2;
PImage background;
Coin coin;
Enemy enemy;

ArrayList<Shoot> shoots = new ArrayList<Shoot>();

void setup() {
  size(920, 520);

  background = loadImage("assets/background2.jpg");
  background.resize(width, height);

  platform1 = new Terrain(100, height-100, width-200, 50);
  platform2 = new Terrain(300, height-350, width/2, 50);

  player = new Player(500, 300, 50, 50);
  
  coin = new Coin(random(width - 30), random(height - 30), 30, 30);
  enemy = new Enemy(0, random(height - 40), 40, 40);
}

void draw() {
  image(background, 0, 0);


  platform1.Display();
  platform2.Display();
  player.Display();
  coin.Display();
  enemy.Display();
  player.CheckCollision(coin);
  enemy.Move();
  
  
  for (int i = 0; i < shoots.size(); i++) {
    Shoot currentShoot = shoots.get(i);
    currentShoot.Display();
    currentShoot.Move();

    // Проверка за колизия с враг
    if (currentShoot.CheckCollision(enemy)) {
      enemy.respawn();
      player.KilledEnemies();
      enemy.is_visible = false; // Унищожаване на врага
      shoots.remove(i); // Премахване на снаряда
      i--; // Намаляване на брояча, защото елемент е премахнат
    }
  }
    // Излиза броят убити врагове на екрана
    fill(255, 0, 0);
    textSize(20);
    textAlign(TOP, LEFT);
    text("Killed Enemies: " + player.killedEnemies, 10, 30);
    
    // Показва надписа за събрани монети само за определен брой фреймове (1 минута в този случай)
    fill(255, 0, 0); // Червен цвят за надписа
    textSize(20);
    textAlign(RIGHT, TOP);
    text("Collected Coins: " + player.collectedCoins, width - 10, 10);
  
}
