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

        BackgroundWorker bw_w = new BackgroundWorker();
        BackgroundWorker bw_b = new BackgroundWorker();

        int milliseconds = 100;
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

            bw_b.WorkerSupportsCancellation = true;
            bw_b.WorkerReportsProgress = true;
            bw_b.DoWork += new DoWorkEventHandler(back_tracking);
            bw_b.ProgressChanged += new ProgressChangedEventHandler(bw_ProgressChanged);
            bw_b.RunWorkerCompleted += new RunWorkerCompletedEventHandler(bw_RunWorkerCompleted);

            bw_w.WorkerSupportsCancellation = true;
            bw_w.WorkerReportsProgress = true;
            bw_w.DoWork += new DoWorkEventHandler(double_wave);
            bw_w.ProgressChanged += new ProgressChangedEventHandler(bw_ProgressChanged);
            bw_w.RunWorkerCompleted += new RunWorkerCompletedEventHandler(bw_RunWorkerCompleted);

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

        private void double_wave(object sender, DoWorkEventArgs e)
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

            BackgroundWorker worker = sender as BackgroundWorker;

            while (true)
            {
                while (queue1.Count > 0)
                {
                    p = queue1.ElementAt<q_element>(0);
                    if (p.level > clevel)   break;

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

                pictureBox1.Invoke((Action)(() => pictureBox1.Refresh()));

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
                pictureBox1.Invoke((Action)(() => pictureBox1.Refresh()));

                if ((worker.CancellationPending == true))
                {
                    e.Cancel = true;
                    return;
                }
                else
                {
                    Thread.Sleep(milliseconds * 10);
                    worker.ReportProgress(clevel);
                }
                clevel++;
            }
        }

        private void back_tracking(object sender, DoWorkEventArgs e)
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

            BackgroundWorker worker = sender as BackgroundWorker;

            while (my_stack.Count > 0)
            {
                q = my_stack.Peek();
                av_path = false;

                foreach (q_element r in rel)
                {
                    x = q.qi + r.qi;
                    y = q.qj + r.qj;

                    if (x >= 0 && x < n && y >= 0 && y < m && marked[x, y] == 2)
                    {
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
                        pictureBox1.Invoke((Action)(() => pictureBox1.Refresh()));
                        break;
                    }
                }
                if (av_path == false)
                {
                    my_array[q.qi, q.qj] = -3;
                    draw_cell(q.qi, q.qj);
                    pictureBox1.Invoke((Action)(() => pictureBox1.Refresh()));
                    my_stack.Pop();
                }
                
                if ((worker.CancellationPending == true))
                {
                    e.Cancel = true;
                    return;
                }
                else
                {
                    Thread.Sleep(milliseconds);
                    worker.ReportProgress(levels++);
                }
            }
        }

        private void button4_Click(object sender, EventArgs e)
        {
            sp = 0;
            queue1 = new Queue<q_element>();
            queue2 = new Queue<q_element>(); 
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
            if (bw_b.IsBusy != true && bw_w.IsBusy != true)
            {
                bw_b.RunWorkerAsync();
            }
        }
        private void start_btn_Click(object sender, EventArgs e)
        {
            if (bw_w.IsBusy != true && bw_b.IsBusy != true)
            {
                bw_w.RunWorkerAsync();
            }
        }
        private void button3_Click(object sender, EventArgs e)
        {
            if (bw_b.WorkerSupportsCancellation == true)
            {
                bw_b.CancelAsync();
            }
            if (bw_w.WorkerSupportsCancellation == true)
            {
                bw_w.CancelAsync();
            }
        }
        private void bw_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            if ((e.Cancelled == true))
            {
                this.tbProgress.Text = "Canceled!";
            }
            else if (!(e.Error == null))
            {
                this.tbProgress.Text = ("Error: " + e.Error.Message);
            }
            else
            {
                this.tbProgress.Text = "Done!";
            }
        }
        private void bw_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            this.tbProgress.Text = e.ProgressPercentage.ToString();
            this.pictureBox1.Refresh();
        }
    }
}
