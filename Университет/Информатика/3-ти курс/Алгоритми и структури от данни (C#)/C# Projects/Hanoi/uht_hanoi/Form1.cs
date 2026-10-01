using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Threading;

namespace uht_hanoi
{
    public partial class Form1 : Form
    {
        Stack<int>[] tower;
        public Graphics gr;
        Point[] base_point;
        Pen my_pen, my_pen2;
        int disk_unit = 10;
        int disk_step = 5;

        public Form1()
        {
            InitializeComponent();

            tower = new Stack<int>[3];
            InitializeTowers();

            pictureBox1.Image = new Bitmap(pictureBox1.Width, pictureBox1.Height);
            pictureBox1.BackColor = Color.White;
            gr = Graphics.FromImage(pictureBox1.Image);

            base_point = new Point[3];
            base_point[0] = new Point { X = 100, Y = 350 };
            base_point[1] = new Point { X = 300, Y = 350 };
            base_point[2] = new Point { X = 500, Y = 350 };

            my_pen = new Pen(Color.Blue, 2);
            my_pen2 = new Pen(Color.Black, 4);

            DrawTowers();
        }

        private void DrawTowers()
        {
            gr.Clear(Color.White);
            for(int i=0; i<3; i++)
            {
                Point endPoint = new Point {X = base_point[i].X, Y = 150};
                gr.DrawLine(my_pen, base_point[i], endPoint); 
            }
            for (int i = 0; i < 3; i++)
            {
                DrawTower(tower[i], base_point[i]);
            }
            pictureBox1.Refresh();
        }

        private void DrawTower(Stack<int> tower, Point bp)
        {
            int disk_num = tower.Count;
            if (disk_num == 0) return;

            int x = bp.X;
            int y = bp.Y - disk_num * disk_step; 

            foreach(int disk in tower)
            {
                gr.DrawLine(my_pen2, x - disk * disk_unit, y, x + disk * disk_unit, y);
                y += disk_step;
            }
        }
        
        private void InitializeTowers()
        {
            for (int i = 0; i < tower.Length; i++)
                tower[i] = new Stack<int>();
        }

        private void Hanoi(int n, char first, char last, char tmp)
        {
            if (n == 0) return;
            Hanoi(n - 1, first, tmp, last);
            tbOut.AppendText(first + " -> " + last + Environment.NewLine);
            Hanoi(n - 1, tmp, last, first);    
        }

        private void GrRefresh()
        {
            DrawTowers();
           Thread.Sleep(300);
        }

        private void HanoiGr(int n, int first, int last, int tmp)
        {
            if (n == 0) return;
            
            HanoiGr(n - 1, first, tmp, last);
            
            int disk = tower[first].Pop();
            tower[last].Push(disk);
            
            GrRefresh();
            
            HanoiGr(n - 1, tmp, last, first);
        }

        private void btnStart_Click(object sender, EventArgs e)
        {
            int n = int.Parse(tbIn.Text);

            tbOut.Text = "";

            InitializeTowers();
            for (int disk = n; disk > 0; disk--) tower[0].Push(disk);

            GrRefresh();
            
            // Hanoi(n, 'A', 'B', 'C');
            HanoiGr(n, 0, 1, 2);
        }
    }
}
