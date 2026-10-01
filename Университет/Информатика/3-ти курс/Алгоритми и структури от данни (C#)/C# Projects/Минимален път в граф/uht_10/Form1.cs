using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace uht_10
{
    public partial class Form1 : Form
    {
        double[,] length;
        int n;
        bool[] marked;
        double[] dist;
        int[] prev;
        double nf = 1;
        int f;

        public Form1()
        {
            InitializeComponent();
            n = 6;
            nf = double.MaxValue / n;

            length = new double[,] {
                { 0, 15, 10, 50, nf, 40}, // 0
                {15,  0, 10, 10, 25, nf}, // 1
                {10, 10,  0, 20, 30, nf}, // 2
                {50, 10, 20,  0, nf, 10}, // 3
                {nf, 25, 30, nf,  0, nf}, // 4
                {40, nf, nf, 10, nf,  0}  // 5
            };
        }

        private void button1_Click(object sender, EventArgs e)
        {
            marked = new bool[n];
            dist = new double[n];
            if (textBox2.Text == "")
                f = 0;
            else
                f = int.Parse(textBox2.Text);

            marked[f] = true;
            prev = new int[n];

            for(int i = 0; i<n; i++)
            {
                dist[i] = length[f, i];
                if (dist[i] < nf) prev[i] = f; else prev[i] = -1;
            }
            prev[f] = -1;
            
            double min;
            int v;

            for(int t = 0; t < n-1; t++)
            {
                v = f;
                min = nf*2;
                for(int i=0; i<n; i++)
                {
                    if (marked[i] == false &&  dist[i] < min)
                    {
                        min = dist[i];
                        v = i;
                    }
                }
                if (v == f) 
                    break;

                marked[v] = true;
                for(int i=0; i<n; i++)
                {
                    if (!marked[i] &&
                         dist[i] > dist[v] + length[v, i])
                    {
                        dist[i] = dist[v] + length[v, i];
                        prev[i] = v;
                    }
                }
            }

            foreach(double k in dist)
            {
                textBox1.AppendText(k + ", ");
            }
            textBox1.AppendText(Environment.NewLine);
            textBox1.AppendText(Environment.NewLine);

            for(int i = 0; i<n; i++)
            {
                if (i == f) continue;
                
                textBox1.AppendText(i + ": ");
                v = i;
                while (prev[v] != -1)
                {
                    v = prev[v];
                    textBox1.AppendText(v + ", ");
                }
                textBox1.AppendText(Environment.NewLine);
            }

        }
    }
}
