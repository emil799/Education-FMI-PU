using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace uht_7
{
    public partial class Form1 : Form
    {
        public Graphics my_pic;
        Image card_image;
        static Image card_back_image;
        bool mouse_drag;
        int dx, dy;

        int num_oc;
        int c1i, c1j;
        int c2i, c2j;

        class TCardDsk
        {
            public Point corner;
            private Point old_corner;
            public Image c_image;
            public bool card_face;
            public bool missing;
            public string f_name; 

            public TCardDsk (int x, int y, string file_name)
            {
                f_name = file_name;
                corner = new Point(x, y);
                c_image = Image.FromFile(file_name);
                card_face = false;
                old_corner = corner;
                missing = false;
            }

            public void SetCorner(int x, int y)
            {
                old_corner = corner;
                corner.X = x;
                corner.Y = y;
            }

            public void DrawCard(Graphics gr, bool turn = false)
            {
                Brush my_brush = Brushes.White;

                if (corner.X != old_corner.X || corner.Y != old_corner.Y)
                {
                    gr.FillRectangle(my_brush, old_corner.X, old_corner.Y,
                                     c_image.Width, c_image.Height);
                }

                if (missing)
                {
                    gr.FillRectangle(my_brush, old_corner.X, old_corner.Y,
                                     c_image.Width, c_image.Height);
                    card_face = true;
                    return;
                }

                if (turn) card_face = !card_face;

                if (card_face)
                {
                    gr.DrawImage(c_image, corner);
                }
                else
                {
                    gr.DrawImage(card_back_image, corner);
                }
            }

            public bool OverCard(int x, int y)
            {
                return
                    x >= corner.X && x <= corner.X + c_image.Width &&
                    y >= corner.Y && y <= corner.Y + c_image.Height;
            }

            public bool Equals(TCardDsk sc)
            {
                if (this.f_name == sc.f_name) return true;
                return false;
            }

        }

        // TCardDsk my_card;
        TCardDsk[,] CardDesk;

        string[] card_file; 

        public Form1()
        {
            InitializeComponent();

            pictureBox1.Image = new Bitmap(pictureBox1.Width, pictureBox1.Height);
            pictureBox1.BackColor = Color.White;
            my_pic = Graphics.FromImage(pictureBox1.Image);
            
            card_back_image = Image.FromFile(@"c:\users\public\cards\back_p.gif");
            // my_card = new TCardDsk(10, 10, @"c:\users\public\cards\card35.gif");

            mouse_drag = false;

            card_file = new string[48];
            int k = 0;
            for(int i=0; i<4; i++)
                for (int j=0; j<6; j++)
                {
                    card_file[k++] = @"c:\users\public\cards\card" + i + j + ".gif";
                    card_file[k++] = @"c:\users\public\cards\card" + i + j + ".gif";
                }
            
            Random rnd = new Random();

            int a, b;
            string str; 

            for(k = 1; k<500; k++)
            {
                a = rnd.Next(24);
                b = rnd.Next(24);
                str = card_file[a]; card_file[a] = card_file[b]; card_file[b] = str;
            }

            CardDesk = new TCardDsk[4, 6];
            k = 0;
            for(int i = 0; i<4; i++)
                for(int j = 0; j<6; j++)
                {
                    CardDesk[i, j] = new TCardDsk(10 + j * 80, 10 + i * 102, card_file[k++]);
                }


            num_oc = 0;
        }

        public void DrawDesk()
        {
            for (int i = 0; i < 4; i++)
                for (int j = 0; j < 6; j++)
                {
                    CardDesk[i, j].DrawCard(my_pic);
                }

        }

        private void button1_Click(object sender, EventArgs e)
        {
            my_pic.Clear(Color.White);
            //my_card.DrawCard(my_pic);

            DrawDesk();

            pictureBox1.Refresh();
        }

        private void pictureBox1_MouseDoubleClick(object sender, MouseEventArgs e)
        {
/*
            if (my_card.OverCard(e.X, e.Y))
            {
                my_card.card_face = !my_card.card_face;
                my_card.DrawCard(my_pic);
                pictureBox1.Refresh();
            }
 */
            if (num_oc == 2) return;

            if (e.X < 10 || e.Y < 10) return;
            
            int j = (e.X - 10) / 80;
            int i = (e.Y - 10) / 102;

            if (i >= 4 || j >= 6) return;

            if (CardDesk[i, j].missing) return;

            if (num_oc == 1 && i == c1i && j == c1j) return;

            num_oc++;
            if (num_oc == 1)
            {
                c1i = i; c1j = j;
            }
            else
            {
                c2i = i; c2j = j;
            }

            CardDesk[i, j].DrawCard(my_pic, true);
            pictureBox1.Refresh(); 
        }

        private void pictureBox1_MouseMove(object sender, MouseEventArgs e)
        {
/*          if (mouse_drag)
            {
                my_card.SetCorner(e.X - dx, e.Y - dy);

                my_card.DrawCard(my_pic);
                pictureBox1.Refresh();
            } 
*/
        }

        private void pictureBox1_MouseDown(object sender, MouseEventArgs e)
        {
/*           
            if (my_card.OverCard(e.X, e.Y))
            {
                mouse_drag = true;
                dx = e.X - my_card.corner.X;
                dy = e.Y - my_card.corner.Y; 
            }
*/
        }

        private void pictureBox1_MouseUp(object sender, MouseEventArgs e)
        {
//            mouse_drag = false;
        }

        private void pictureBox1_MouseClick(object sender, MouseEventArgs e)
        {
            if (num_oc == 2)
            {
                if (CardDesk[c1i, c1j].Equals(CardDesk[c2i, c2j]))
                {
                    CardDesk[c1i, c1j].missing = true;
                    CardDesk[c2i, c2j].missing = true;
                }
                CardDesk[c1i, c1j].DrawCard(my_pic, true);
                CardDesk[c2i, c2j].DrawCard(my_pic, true);
                pictureBox1.Refresh();
                num_oc = 0;
            }
        }
    }
}
