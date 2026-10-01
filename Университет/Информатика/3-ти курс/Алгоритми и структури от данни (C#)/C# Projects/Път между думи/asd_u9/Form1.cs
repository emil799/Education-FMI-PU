using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace asd_u9
{
    public partial class Form1 : Form
    {
        class QueueElement
        {
            public int word_index { get; set; }
            public int depth { get; set; }
            public int prev_word { get; set; }
        }
        Queue<QueueElement> searching_queue;

        string[] dict;
        string[] all_words; 

        List<string> w_res;
        Boolean[] mark;
        List<int>[] desc;
        int n;

        bool str_neigh(string a, string b)
        {
            int n = a.Length;
            int i, diff = 0;
            for (i = 0; i < n; i++)
            {
                if (a[i] != b[i]) diff++;
                if (diff > 1) return false;
            }
            if (diff == 1) return true;
            return false;
        }

        void DisplayPath()
        {
            QueueElement q;

            int k = searching_queue.Count - 1;
            while (k > -1)
            {
                q = searching_queue.ElementAt(k);
                k = q.prev_word;
                textBox1.AppendText(dict[q.word_index] + Environment.NewLine);
            }
        }

        int FindWord(string str)
        {
            int l, r, m, cmp;
            l = 0; r = dict.Length - 1;
            while (l <= r)
            {
                m = (l + r) / 2;
                cmp = str.CompareTo(dict[m]);
                if (cmp == 0)
                    return m;
                else if (cmp < 0)
                    r = m - 1;
                else
                    l = m + 1;
            }
            return -1;
        }

        bool SearchWordsPath(string w1, string w2)
        {
            int k;
            k = FindWord(w1);

            if (k == -1) return false;
            
            mark[k] = true;

            searching_queue.Enqueue(new QueueElement() 
                { word_index = k, depth = 1, prev_word = -1 });
            
            k = FindWord(w2);

            if (k == -1) return false;
            
            // основен цикъл за обхождането в ширина
            QueueElement q; 
            
            k = 0;
            while (k < searching_queue.Count)
            {
                q = searching_queue.ElementAt(k);
                foreach (int i in desc[q.word_index])
                    if (!mark[i])
                    {
                        mark[i] = true;
                        searching_queue.Enqueue(new QueueElement() 
                             {word_index = i, depth = q.depth + 1, prev_word = k });

                        if (dict[i] == w2)
                        {
                            DisplayPath();
                            return true;
                        }
                    }
                k++;
            }
            return false;
        }

        public void CallWordPathFinder(string w1, string w2)
        {
            int i, j;
            
            w_res = new List<string>();

            searching_queue = new Queue<QueueElement>();

            mark = new bool[n];
            
            desc = new List<int>[n];

            for (i = 0; i < n; i++)
            {
                desc[i] = new List<int>();
                mark[i] = false;
            }

            // ако две думи са съседни, ги правим съседни и в графа
            for (i = 0; i < n - 1; i++)
                for (j = i + 1; j < n; j++)
                    if (str_neigh(dict[i], dict[j]))
                    {
                        desc[i].Add(j);
                        desc[j].Add(i);
                    }
            
             if (! SearchWordsPath(w1, w2))
                textBox1.AppendText(
                    "Някоя от думите липсва в речника или няма път между тях.\n");
        }
    
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            int wl = 5;
            all_words = System.IO.File.ReadAllLines("words.txt");

            n = 0;
            foreach (string word in all_words)
                if (word.Length == wl) n++;

            dict = new string[n];
            n = 0;
            foreach (string word in all_words)
                if (word.Length == wl)
                {
                    dict[n++] = word;
                }

            //CallWordPathFinder("math", "rose");
            CallWordPathFinder("rings", "macaw");
        }
    }
}
