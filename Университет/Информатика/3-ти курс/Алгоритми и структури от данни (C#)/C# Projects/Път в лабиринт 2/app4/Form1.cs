using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;

namespace app4
{
    public partial class Form1 : Form
    {
        public Graphics gr;
        int c_size = 20;
        int n = 10;
        int m = 16;
        int[,] my_array;
        int[,] marked;
        Pen my_pen;
        Point base_point;
        public Color cblack;
        int sp;

        public class q_element 
        {
            public int qi, qj;
            public int level;
        }
        Queue<q_element> queue1, queue2;

        int milliseconds = 500;
        q_element[] rel;
        bool av_path;
        Stack<q_element> my_stack;
        int levels;
        
        public Form1()
        {
            InitializeComponent();
            
            pictureBox1.Image = new Bitmap(pictureBox1.Width, pictureBox1.Height);
            pictureBox1.BackColor = Color.White;
            gr = Graphics.FromImage(pictureBox1.Image);

            base_point = new Point { X = 10, Y = 10 };

            my_array = new int[n, m];
            marked = new int[n, m];
            
            my_pen = new Pen(Color.Blue, 1);
            sp = 0;
            InitTable();

            queue1 = new Queue<q_element>();
            queue2 = new Queue<q_element>();

            rel = new q_element[4];
            rel[0] = new q_element() { qi = 0, qj = -1 };
            rel[1] = new q_element() { qi = 0, qj = 1 };
            rel[2] = new q_element() { qi = -1, qj = 0 };
            rel[3] = new q_element() { qi = 1, qj = 0 };
        }

        public void draw_cell(int i, int j)
        {
            Brush br;
            switch (my_array[i, j])
            {
                case 0: br = Brushes.Aquamarine; break;
                case -1: br = Brushes.Black; break;
                case 1: br = Brushes.Red; break;
                case -3: br = Brushes.Yellow; break;
                case -4: br = Brushes.Green; break;
                default: br = Brushes.Pink; break;
            }
            int y = base_point.X + i * c_size + 3;
            int x = base_point.Y + j * c_size + 3;
            gr.FillRectangle(br, x, y, c_size - 5, c_size - 5);
        }

        public void InitTable()
        {
            for (int i = 0; i <= n; i++)
            {
                gr.DrawLine(my_pen, base_point.X, base_point.Y + i * c_size, 
                            base_point.X + m * c_size, base_point.Y + i * c_size);
            }
            for (int i = 0; i <= m; i++)
            {
                gr.DrawLine(my_pen, base_point.X + i * c_size, base_point.Y,
                            base_point.X + i * c_size, base_point.Y + n * c_size);
            }
            for (int i=0; i<n; i++) for (int j=0; j<m; j++) draw_cell(i,j);
        }

        private void pictureBox1_MouseDoubleClick(object sender, MouseEventArgs e)
        {
            if (e.X < base_point.X || e.Y < base_point.Y ||
                e.X > base_point.X + m * c_size ||
                e.Y > base_point.Y + n * c_size) return;

            int i = (e.Y - base_point.Y) / c_size;
            int j = (e.X - base_point.X) / c_size;

            if (button1.FlatStyle == FlatStyle.Popup)
            {
                if (my_array[i, j] > 0) return;

                if (my_array[i, j] == 0)
                    my_array[i, j] = -1;
                else if (my_array[i, j] == -1)
                    my_array[i, j] = 0;
                draw_cell(i, j);
                pictureBox1.Refresh();
                return;
            }
            if (button2.FlatStyle == FlatStyle.Popup)
            {
                if (my_array[i, j] < 0 || my_array[i, j] > 1) return;

                if (my_array[i, j] == 0)
                {
                    if (sp == 2) return;
                    my_array[i, j] = 1;
                    sp++;
                }
                else if (my_array[i, j] == 1)
                {
                    my_array[i, j] = 0;
                    sp--;
                }
                draw_cell(i, j);
                pictureBox1.Refresh();
                return;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            if (button1.FlatStyle == FlatStyle.Standard)
            {
                button1.FlatStyle = FlatStyle.Popup;
                button2.FlatStyle = FlatStyle.Standard;
            }
            else if (button1.FlatStyle == FlatStyle.Popup)
            {
                button1.FlatStyle = FlatStyle.Standard;
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            if (button2.FlatStyle == FlatStyle.Standard)
            {
                button2.FlatStyle = FlatStyle.Popup;
                button1.FlatStyle = FlatStyle.Standard;
            }
            else if (button2.FlatStyle == FlatStyle.Popup)
            {
                button2.FlatStyle = FlatStyle.Standard;
            }
        }

        private void double_wave()
        {
            if (sp != 2) return;

            int nq = 0;
            for (int i = 0; i < n; i++)
                for (int j = 0; j < m; j++)
                {
                    if (my_array[i, j] == 1)
                    {
                        if (nq == 0)
                        {
                            queue1.Enqueue(new q_element { qi = i, qj = j, level = 1 });
                            marked[i, j] = 1;
                            nq++;
                        }
                        else
                        {
                            queue2.Enqueue(new q_element { qi = i, qj = j, level = 1 });
                            marked[i, j] = 2;
                        }
                    }
                    marked[i, j] = 0;
                }

            int x, y, clevel = 1;
            q_element q, p;

            while (true)
            {
                while (queue1.Count > 0)
                {
                    p = queue1.ElementAt<q_element>(0);
                    if (p.level > clevel) break;

                    q = queue1.Dequeue();
                    foreach (q_element r in rel)
                    {
                        x = q.qi + r.qi;
                        y = q.qj + r.qj;

                        if (x >= 0 && x < n && y >= 0 && y < m && marked[x, y] == 2)
                        {
                            // there is a path
                            return;
                        }
                        if (x >= 0 && x < n && y >= 0 && y < m &&
                            my_array[x, y] == 0 && marked[x, y] == 0)
                        {
                            queue1.Enqueue(new q_element() { qi = x, qj = y, level = q.level + 1 });
                            marked[x, y] = 1;
                            my_array[x, y] = 2;
                            draw_cell(x, y);
                        }
                    }
                }
                pictureBox1.Refresh();
                Thread.Sleep(milliseconds);

                while (queue2.Count > 0)
                {
                    if (queue2.ElementAt<q_element>(0).level > clevel) break;

                    q = queue2.Dequeue();
                    foreach (q_element r in rel)
                    {
                        x = q.qi + r.qi;
                        y = q.qj + r.qj;

                        if (x >= 0 && x < n && y >= 0 && y < m && marked[x, y] == 1)
                        {
                            // there is a path
                            return;
                        }
                        if (x >= 0 && x < n && y >= 0 && y < m &&
                            my_array[x, y] == 0 && marked[x, y] == 0)
                        {
                            queue2.Enqueue(new q_element() { qi = x, qj = y, level = q.level + 1 });
                            marked[x, y] = 2;
                            my_array[x, y] = 2;
                            draw_cell(x, y);
                        }
                    }
                }
                pictureBox1.Refresh();
                Thread.Sleep(milliseconds);
                
                clevel++;
            }
        }

        private void back_tracking()
        {
            if (sp != 2) return;

            my_stack = new Stack<q_element>();
            levels = 0;

            int nq = 0;
            for (int i = 0; i < n; i++)
                for (int j = 0; j < m; j++)
                    if (my_array[i, j] == 1)
                    {
                        if (nq == 0)
                        {
                            my_stack.Push(new q_element { qi = i, qj = j, level = 1 });
                            marked[i, j] = 1;
                            nq++;
                        }
                        else
                        {
                            marked[i, j] = 2;
                        }
                    }

            q_element q;
            int x, y;

            while (my_stack.Count > 0)
            {
                q = my_stack.Peek();
                av_path = false;

                Thread.Sleep(milliseconds);
                foreach (q_element r in rel)
                {
                    x = q.qi + r.qi;
                    y = q.qj + r.qj;

                    if (x >= 0 && x < n && y >= 0 && y < m && marked[x, y] == 2)
                    {
                        while (my_stack.Count > 1)
                        {
                            q = my_stack.Pop();
                            my_array[q.qi, q.qj] = -4;
                            draw_cell(q.qi, q.qj);
                            pictureBox1.Refresh();
                            Thread.Sleep(milliseconds);
                        }
                        // there is a path
                        
                        return;
                    }
                    if (x >= 0 && x < n && y >= 0 && y < m && my_array[x, y] == 0)
                    {
                        marked[x, y] = 1;
                        my_array[x, y] = q.level + 1;
                        my_stack.Push(new q_element() { qi = x, qj = y, level = q.level + 1 });
                        av_path = true;
                        draw_cell(x, y);
                        pictureBox1.Refresh();
                        break;
                    }
                }
                if (av_path == false)
                {
                    my_array[q.qi, q.qj] = -3;
                    draw_cell(q.qi, q.qj);
                    pictureBox1.Refresh();
                    my_stack.Pop();
                }
            }
        }

        private void button4_Click(object sender, EventArgs e)
        {
            sp = 0;
            for (int i = 0; i < n; i++)
                for (int j = 0; j < m; j++)
                {
                    my_array[i, j] = 0;
                    marked[i,j] = 0;
                    draw_cell(i,j);
                }
            pictureBox1.Refresh();
        }
        
        private void back_tr_Click(object sender, EventArgs e)
        {
            back_tracking();
        }

        private void start_btn_Click(object sender, EventArgs e)
        {
            double_wave();
        }
           
    }
}
