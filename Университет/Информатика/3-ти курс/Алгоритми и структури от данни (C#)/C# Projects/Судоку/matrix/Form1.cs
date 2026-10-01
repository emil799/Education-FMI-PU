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

namespace matrix
{
    public partial class Form1 : Form
    {
        TextBox[,] s_table;
        bool[,] s_marked;
        HashSet<int>[] row;
        HashSet<int>[] col;
        HashSet<int>[,] sq33;
 
        public Form1()
        {
            InitializeComponent();
            s_table = new TextBox[9, 9];
            for(int i=0; i<9; i++)
                for(int j=0; j<9; j++)
                {
                    s_table[i, j] = new TextBox();
                    InitMyTextBox(s_table[i, j], i, j);
                }
            row = new HashSet<int>[9];
            col = new HashSet<int>[9];
            sq33 = new HashSet<int>[3, 3];
        }

        private void ClearSets()
        {
            for (int i = 0; i < 9; i++) row[i] = new HashSet<int>();
            for (int i = 0; i < 9; i++) col[i] = new HashSet<int>();
            for (int i = 0; i < 3; i++)
                for (int j = 0; j < 3; j++)
                    sq33[i, j] = new HashSet<int>();
            s_marked = new bool[9, 9];
        }

        private void InitMyTextBox(TextBox tb, int i, int j)
        {
            tb.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            tb.Location = new System.Drawing.Point(20+j*32, 60+i*31);
            tb.Name = "tb" + i.ToString() + j.ToString();
            tb.Size = new System.Drawing.Size(30, 28);
            tb.TabIndex = 0;
            this.Controls.Add(tb);
        }

        private void GetNextCoord(ref int r, ref int c)
        {
            c++; if (c == 9) { r++; c = 0; } // 87981
            /*
            if (r < c) r++;
            else if (c > 0) c--;
            else { c = r + 1; r = 0; } */
            // if (c == 0) { c = r + 1; r = 0; } else { r++; c--; } 
        }

        private void GetPrevCoord(ref int r, ref int c)
        {
            c--; if (c < 0) { r--; c = 8; }
            /*
            if (r > c) c++;
            else if (r > 0) r--;
            else { r = c - 1; c = 0; } */
            // if (r == 0) { r = c - 1; c = 0; } else { r--; c++; }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            ClearSets();
            int num;
            for(int i=0; i<9; i++)
                for(int j=0; j<9; j++)
                    if (s_table[i,j].Text != "")
                    {
                        num = int.Parse(s_table[i, j].Text);
                        row[i].Add(num);
                        col[j].Add(num);
                        sq33[i / 3, j / 3].Add(num);
                        s_marked[i, j] = true;
                        s_table[i, j].BackColor = Color.Aqua;
                        s_table[i, j].Refresh();
                    }

            int r = 0, c = 0;
            int n = 0;

            while (r>=0 && r<9 && c<9)
            {
                if (s_marked[r, c])
                {
                    GetNextCoord(ref r, ref c);
                    continue;
                }
                if (s_table[r,c].Text == "")
                {
                    num = 1;
                }
                else
                {
                    num = int.Parse(s_table[r, c].Text);
                    row[r].Remove(num);
                    col[c].Remove(num);
                    sq33[r / 3, c / 3].Remove(num);

                    num++;
                    if (num > 9)
                    {
                        s_table[r, c].Text = "";
                        s_table[r, c].Refresh();
                        do
                        {
                            GetPrevCoord(ref r, ref c);
                            if (r < 0) break;
                        } while (s_marked[r, c]);
                        continue; 
                    }
                }

                while(num <= 9 && 
                      ( row[r].Contains(num) || col[c].Contains(num) ||
                        sq33[r / 3, c / 3].Contains(num)))
                {
                    num++; n++;
                }
                if (num > 9)
                {
                    s_table[r, c].Text = "";
                    s_table[r, c].Refresh();
                    do
                    {
                        GetPrevCoord(ref r, ref c);
                        if (r < 0) break;
                    } while (s_marked[r, c]);
                    continue;
                }
                n++;
                s_table[r, c].Text = num.ToString();
                s_table[r, c].Refresh();
                Thread.Sleep(100);

                row[r].Add(num);
                col[c].Add(num);
                sq33[r / 3, c / 3].Add(num);

                GetNextCoord(ref r, ref c);
            }
            tbSample.Text = n.ToString();
        }
    }
}
