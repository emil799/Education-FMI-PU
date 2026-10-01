using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace uht_2
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void DisplayArr(int[] ar)
        {
            foreach (int v in ar)
                tbOut.AppendText(v.ToString() + ' ');
            tbOut.AppendText(Environment.NewLine);
        }

        private void SwapElements(int[] a, int i, int j)
        {
            int tmp;
            tmp = a[i];
            a[i] = a[j];
            a[j] = tmp;
        }

        private void SwapInt(ref int a, ref int b)
        {
            int tmp;
            tmp = a;
            a = b;
            b = tmp;
        }

        private bool NextPerm(int[] pm)
        {
            int k = pm.Length - 1;
            if (pm[k] > pm[k - 1])
            {
                SwapInt(ref pm[k], ref pm[k - 1]);
                return true;
            }

            while (k > 0 && pm[k - 1] > pm[k]) k--;
            if (k == 0) return false;

            int t = k - 1;

            for (int i = k, j = pm.Length - 1; i < j; i++, j--)
            {
                SwapElements(pm, i, j);
            }

            while (pm[k] < pm[t]) k++;

            SwapElements(pm, t, k);

            return true;
        }

        private void btnPermIterat_Click(object sender, EventArgs e)
        {
            int n = int.Parse(tbIn.Text);
            int[] perm = new int[n];
            for (int i = 0; i < n; i++) perm[i] = i + 1;

            DisplayArr(perm);
            while (NextPerm(perm))
            {
                DisplayArr(perm);
            }

        }

        private void ReverseArray(int[] t, int l, int r=0)
        {
            if (r == 0) r = t.Length - 1;
            while(l<r)
            {
                SwapElements(t, l, r);
                l++; r--;
            }
        }
        
        private void PermRecursive(int[] pm, int k)
        {
            if (k == pm.Length-1)
            {
                DisplayArr(pm);
                return;
            }

            PermRecursive(pm, k + 1);
            for(int i=k+1; i<pm.Length; i++)
            {
                // ReverseArray(pm, k + 1);
                SwapElements(pm, k, i);
                PermRecursive(pm, k + 1);
            } 
        }

        private void btnPermRecurs_Click(object sender, EventArgs e)
        {
            int n = int.Parse(tbIn.Text);
            
            int[] perm = new int[n];
            for (int i = 0; i < n; i++) perm[i] = i + 1;

            PermRecursive(perm, 0);
        }

        private bool NextComb(int[] cm, int n)
        {
            int i = cm.Length-1;

            while (i>=0)
            {
                if (cm[i] < n-cm.Length+i+1) //n-k+i+1
                {
                    cm[i]++;
                    for (i++; i < cm.Length; i++)
                    {
                        cm[i] = cm[i - 1] + 1;
                    }
                    return true;
                }
                i--;
            }
            return false;
        }

        private void button1_Click(object sender, EventArgs e)
        {
            int n = int.Parse(tbIn.Text);
            int k = int.Parse(tbInK.Text);

            if (k > n) return;

            int[] comb = new int[k];
            for (int i = 0; i < k; i++) comb[i] = i + 1;

            DisplayArr(comb);
            while (NextComb(comb,n))
            {
                DisplayArr(comb);
            }
            tbOut.AppendText(Environment.NewLine);
        }

        private void button2_Click(object sender, EventArgs e)
        {   int n = int.Parse(tbIn.Text);
            int k = int.Parse(tbInK.Text);

            HashSet<char> my_set = new HashSet<char>(); // n
            HashSet<char> my_comb = new HashSet<char>(); // k

            if (k > n) return;

            // int[] comb = new int[k];

            for (int i = 0; i < n; i++)
            {
                my_set.Add((char)('A' + i));
            }

//            GenAllCombinations(comb, 0, my_set, k);
            GenAllCombinations2(my_comb, my_set, k);

            tbOut.AppendText(Environment.NewLine);
        }

        private void GenAllCombinations(int[] pm, int pos, 
            HashSet<int> rest_set, int k)
        {
            if (rest_set.Count == 0 || pos == pm.Length ||
                rest_set.Count < (pm.Length - pos))
            {
                return;
            }

            HashSet<int> rest = new HashSet<int>(rest_set); 

            while (rest.Count > 0)
            {
                int v = rest.Min();
                rest.Remove(v);
                pm[pos] = v;
                if (pos == pm.Length - 1) DisplayArr(pm);
                GenAllCombinations(pm, pos+1, rest, k-1);
            }
        }

        private void DisplaySet(HashSet<char> hs)
        {
            foreach (char v in hs)
                tbOut.AppendText(v.ToString() + ' ');
            tbOut.AppendText(Environment.NewLine);
        }

        private void GenAllCombinations2(HashSet<char> comb, 
            HashSet<char> rest_set, int k)
        {
            if (comb.Count == k)
            {
                DisplaySet(comb);
                return;
            } 
            if (rest_set.Count == 0) 
                return;

            HashSet<char> rest = new HashSet<char>(rest_set);
            foreach(char v in rest_set)
            {
                rest.Remove(v);
                comb.Add(v);
                GenAllCombinations2(comb, rest, k);
                comb.Remove(v);
            }
        }

    }
}
