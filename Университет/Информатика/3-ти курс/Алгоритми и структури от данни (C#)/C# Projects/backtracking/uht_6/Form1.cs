using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace uht_6
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private bool CheckSolution(int[] arr, int k)
        {
            int s = (k + 1) / 2;
            bool fl; 

            for (int i = 1; i <= s; i++)
            {
                fl = true;
                for (int j = k; j > k - i; j--)
                {
                    if (arr[j] != arr[j - i])
                    {
                        fl = false;
                        break;
                    }
                }
                if (fl) return false;
            }
            return true;
        }

        private void button1_Click(object sender, EventArgs e)
        {
            int n = int.Parse(textBox1.Text);
            int[] str = new int[n];
            textBox2.Text = "";
            int count = 0;

            int i = 0;
            str[i] = 1;
            i = 1; str[i] = 0;
            while (i >= 0)
            {
                str[i]++;
                if (str[i] > 3)
                {
                    i--; // continue;
                }
                else
                    if (CheckSolution(str, i))
                    {
                        if (i == n - 1)
                        {
                            foreach (int v in str)
                                textBox2.AppendText(v.ToString());
                            textBox2.AppendText(Environment.NewLine);
                         break;
                        //count++;

                        }
                        else
                        {
                            i++;
                            str[i] = 0;
                        }
                    }
            }
            //textBox2.AppendText(count + Environment.NewLine);

        }
    }
}
