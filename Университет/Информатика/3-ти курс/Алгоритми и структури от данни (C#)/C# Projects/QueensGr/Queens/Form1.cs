using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;

namespace Queens
{
    public partial class Form1 : Form
    {
        public Graphics gr;
        Point base_point;
        Pen my_pen;
        int c_size = 50;
        Image queen;
        bool next_sol;

        public Form1()
        {
            InitializeComponent();
            
            pictureBox1.Image = new Bitmap(pictureBox1.Width, pictureBox1.Height);
            pictureBox1.BackColor = Color.White;
            gr = Graphics.FromImage(pictureBox1.Image);

            base_point = new Point { X = 10, Y = 10 };
            my_pen = new Pen(Color.Blue, 1);

            queen = new Bitmap(System.Reflection.Assembly.GetEntryAssembly().
                GetManifestResourceStream("Queens.q.png"));
            next_sol = false;
        }

        public void draw_cell(int i, int j)
        {
            Brush br;
            br = Brushes.Aquamarine;
            int y = base_point.X + i * c_size + 3;
            int x = base_point.Y + j * c_size + 3;
            gr.FillRectangle(br, x, y, c_size - 5, c_size - 5);
        }

        public void DrawQueen(int x, int y)
        {
            Point p = new Point(base_point.X + y * c_size + 5,
            base_point.Y + x * c_size + 5);

            gr.DrawImage(queen, p);
        }

        public void InitTable(int n)
        {
            for (int i = 0; i <= n; i++)
            {
                gr.DrawLine(my_pen, base_point.X, base_point.Y + i * c_size,
                            base_point.X + n * c_size, base_point.Y + i * c_size);
            }
            for (int i = 0; i <= n; i++)
            {
                gr.DrawLine(my_pen, base_point.X + i * c_size, base_point.Y,
                            base_point.X + i * c_size, base_point.Y + n * c_size);
            }
            for (int i = 0; i < n; i++) 
                for (int j = 0; j < n; j++) 
                    draw_cell(i, j);
        }


        bool CheckSolution(int[] arr, int pos)
        {
            if (pos == 0) return true;

            for (int i = 0; i < pos; i++)
            {
                //  проверка за вертикал
                if (arr[pos] == arr[i]) return false;
                // проверка за диагонал успореден на главния
                if (pos - arr[pos] == i - arr[i]) return false;
                // проверка за диагонал успореден на вторичния (обратния)
                if (pos + arr[pos] == i + arr[i]) return false;
            }
            return true;
        }

        void DrawDesk(int[] desk)
        {
            for (int i = 0; i < desk.Length; i++)
                DrawQueen(i, desk[i]);
        }

        private void button1_Click(object sender, EventArgs e)
        {
            int n = int.Parse(textBox1.Text);
            int[] desk = new int[n];

            int nsol = 0;
            int i = 0;
            desk[i] = 0;
            i = 1; desk[i] = -1;
            next_sol = false;
            while (i >= 0)
            {
                desk[i]++;
                if (desk[i] == n)
                {
                    i--;
                }
                else 
                if (CheckSolution(desk, i))
                {
                    if (i == n - 1)
                    {
                        nsol++;
                        textBox2.Text = nsol.ToString();
                        textBox2.Refresh();

                        InitTable(n);
                        DrawDesk(desk);
                        pictureBox1.Refresh();
                        Thread.Sleep(600);
                        i--;
                    }
                    else
                    {
                        i++;
                        desk[i] = -1;
                    }
                }
            }
        }

        private void button1_Click_1(object sender, EventArgs e)
        {
            next_sol = true;        
        }
    }
}

