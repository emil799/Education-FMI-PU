using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace asd_l4
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void DisplayArray(int[] a)
        {
            foreach(int v in a)  textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);
        }

        private void quick_sort(int[] a, int left, int right)
        {
            int i = left, j = right;
            int x = a[(i + j) / 2];
            int tmp;

            while(i<=j)
            {
                while (i <= right && a[i] < x) i++;
                while (left <= j && a[j] > x) j--;
                if (i <= j)
                {
                    tmp = a[i]; a[i] = a[j]; a[j] = tmp;
                    i++; j--;
                }
            }
            if (left < j) quick_sort(a, left, j);
            if (i < right) quick_sort(a, i, right);
        }

        private void ShellSort(int[] a)
        {
            int h = 1;
            int n = a.Length;

            while (h<n) h <<= 1; // h = h * 2;
            h = h >> 1 - 1;

            int k, i;
            int t;

            while(h > 0)
            {
                for (k = h; k < n; k++)
                {
                    t = a[k];
                    for (i = k - h; i >= 0 && t < a[i]; i -= h)
                        a[i + h] = a[i];
                    a[i + h] = t;
                }
                h >>= 1; // h = h/2
            }

        }

        private void button1_Click(object sender, EventArgs e)
        {
            int[] arr = new int[] { 15, 2, 17, 13, 3, 8, 2, 4, 350 };
            int n = arr.Length;

            n = 3000000;
            arr = new int[n];
            DateTime dt;
            int[] b = new int[n];
 
            dt = DateTime.Now;

            Array.Sort(arr);

            Random rand = new Random();

            for (int i = 0; i < n; i++)
            {
                arr[i] = rand.Next(4, 39999);
            }
            //DisplayArray(arr);
            
            arr.CopyTo(b,0);

            dt = DateTime.Now;
            textBox1.AppendText(dt.ToLongTimeString() + Environment.NewLine);
            ShellSort(arr);
            dt = DateTime.Now;
            textBox1.AppendText(dt.ToLongTimeString() + Environment.NewLine);
            //DisplayArray(arr);

            b.CopyTo(arr, 0);

            dt = DateTime.Now;
            textBox1.AppendText(dt.ToLongTimeString() + Environment.NewLine);
            quick_sort(arr, 0, n - 1);
            dt = DateTime.Now;
            textBox1.AppendText(dt.ToLongTimeString() + Environment.NewLine);
            //DisplayArray(arr);

            bool sorted = true;

            for(int i=1; i<arr.Length; i++)
            {
                if (arr[i - 1] > arr[i]) { sorted = false; break; }
            }

            if (sorted)
                textBox1.AppendText("The array is sorted");
        }
    }
}
