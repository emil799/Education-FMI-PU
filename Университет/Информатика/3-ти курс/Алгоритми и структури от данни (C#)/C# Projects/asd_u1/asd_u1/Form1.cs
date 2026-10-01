using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace asd_u1
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        string reverse(string str)
        {
            string res = "";
            int k = 0;

            for(int i=str.Length-1; i>=0; i--)
            {
                res = res + str[i];
            }
            return res;
        }

        void str_to_int_array(int[] arr, string str)
        {
            str = reverse(str);

            int i;
            for(i = 0; i < str.Length; i++)
            {
                arr[i] = str[i] - '0';
            }
            for (i++; i < arr.Length; i++) arr[i] = 0; 
        }

        void display_int_array(int[] arr)
        {
            string res = "";
            foreach (int v in arr) res = res + (char)(v+'0');

            res = reverse(res);

            textBox3.AppendText(res + Environment.NewLine);
        }

        void add_arrays(int[] arr_a, int[] arr_b, int[] arr_c)
        {
            int cr = 0;

            for(int i=0; i<arr_a.Length; i++)
            {
                arr_c[i] = arr_a[i] + arr_b[i] + cr;
                cr = 0;
                if (arr_c[i] >= 10)
                {
                    arr_c[i] -= 10;
                    cr = 1;
                }
            }
       }

        private void button1_Click(object sender, EventArgs e)
        {
            string a = textBox1.Text;
            string b = textBox2.Text;

            int max_len = a.Length;
            if (max_len < b.Length) max_len = b.Length;
            max_len++;

            int[] arr_a = new int[max_len];
            int[] arr_b = new int[max_len];

            str_to_int_array(arr_a, a);
            str_to_int_array(arr_b, b);

            display_int_array(arr_a);
            display_int_array(arr_b);

            int[] arr_c = new int[max_len];

            add_arrays(arr_a, arr_b, arr_c);

            display_int_array(arr_c);


        }
    }
}
