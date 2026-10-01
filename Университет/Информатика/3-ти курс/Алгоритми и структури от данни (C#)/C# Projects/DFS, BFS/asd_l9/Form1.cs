using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace asd_l9
{
    public partial class Form1 : Form
    {
        int n = 8;

        int[,] my_graph;
        bool[] marked;
        
        List<int>[] my_graph2;

        public Form1()
        {
            InitializeComponent();
            my_graph = new int[,]
            {
                {0, 0, 0, 0, 0, 0, 0, 0},
                {0, 0, 1, 1, 0, 1, 0, 1},
                {0, 1, 0, 0, 1, 0, 1, 0},
                {0, 1, 0, 0, 0, 1, 0, 0}, 
                {0, 0, 1, 0, 0, 0, 1, 1},
                {0, 1, 0, 1, 0, 0, 0, 1},
                {0, 0, 1, 0, 1, 0, 0, 0},
                {0, 1, 0, 0, 1, 1, 0, 0}
            };
            marked = new bool[n];
        }

        private void DepthFirstSearch(int v)
        {
            marked[v] = true;
            textBox1.AppendText(v + "  ");

            for (int k = 1; k < n; k++)
            {
                if (my_graph[v, k] == 1 && !marked[k])
                    DepthFirstSearch(k);
            }
        }

        private void BreadthFirstSearch(int fn)
        {
            Queue<int> mq = new Queue<int>();
            mq.Enqueue(fn);
            marked[fn] = true;
            int v;
            while (mq.Count > 0)
            {
                v = mq.Dequeue();
                textBox1.AppendText(v + "  ");
                for(int k = 0; k < n; k++)
                    if (my_graph[v, k] == 1 && !marked[k]){
                        mq.Enqueue(k);
                        marked[k] = true;
                    }
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            marked = new bool[n];
            for (int i = 0; i < n; i++) marked[i] = false;

            for (int i = 1; i < n; i++)
              if (!marked[i])
                DepthFirstSearch(i);


            textBox1.AppendText(Environment.NewLine);

            for (int i = 0; i < n; i++) marked[i] = false;
            BreadthFirstSearch(1);
        }

        private void button2_Click(object sender, EventArgs e)
        {
            my_graph2 = new List<int>[n];
            marked = new bool[n];
            for (int ii = 0; ii < n; ii++) marked[ii] = false;

            int i,j;
            for (i = 0; i < n; i++)
                my_graph2[i] = new List<int>();

            for (i = 0; i < n; i++)
                for (j = 0; j < n; j++)
                    if (my_graph[i, j] == 1)
                    {
                        my_graph2[i].Add(j);
                        my_graph2[j].Add(i);
                    }
            DepthFirstSearch2(1);
        }

        private void DepthFirstSearch2(int v)
        {
            marked[v] = true;
            textBox1.AppendText(v + "  ");

            foreach (int k in my_graph2[v])
                if (!marked[k])
                    DepthFirstSearch2(k);
        }
        
        private void BreadthFirstSearch2(int fn)
        {
            Queue<int> mq = new Queue<int>();
            mq.Enqueue(fn);
            marked[fn] = true;
            int v;
            while (mq.Count > 0)
            {
                v = mq.Dequeue();
                textBox1.AppendText(v + "  ");
                foreach (int k in my_graph2[v])
                    if (!marked[k])
                    {
                        mq.Enqueue(k);
                        marked[k] = true;
                    }
            }
        }


    }
}
