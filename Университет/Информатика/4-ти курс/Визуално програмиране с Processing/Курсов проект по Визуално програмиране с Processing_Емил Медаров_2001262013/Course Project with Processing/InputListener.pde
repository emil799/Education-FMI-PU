
void keyPressed() {
  player.Move(key);
  if (key == ' ') {
    float shootX = player.x + player.w / 2;
    float shootY = player.y + player.h / 2;
    float shootSpeed = 5;
    
    Shoot newShoot = new Shoot(shootX, shootY, 20, 20, color(255, 0, 0), shootSpeed * player.shootingDirection);
    shoots.add(newShoot);
  }
}
void keyReleased() {
  
}
void mousePressed() {
  
}
void mouseReleased() {
  
}
void mouseClicked() {
  
}
void mouseDragged() {
  
}
