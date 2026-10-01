using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace asd_u5
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            int[] arr = new int[] { 90, 30, 12, 2, 8, 211, 54};

            Array.Sort(arr);
            Queue<int> q1 = new Queue<int>(arr);

            arr = new int[] { 1, 23, 45, 76, 200, 400 }; 
            Queue<int> q2 = new Queue<int>(arr);

            foreach (int v in q1) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);
            foreach (int v in q2) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);
            
            Queue<int> res = new Queue<int>();

            while (q1.Count > 0 && q2.Count > 0)
            {
                if (q1.Peek() <= q2.Peek())
                {
                    res.Enqueue(q1.Dequeue());
                }
                else
                {
                    res.Enqueue(q2.Dequeue());
                }
            }
            if (q1.Count > 0)
            {
                foreach(int v in q1) res.Enqueue(v);
                q1.Clear();
            }
            else
            {
                foreach (int v in q2) res.Enqueue(v);
                q2.Clear();
            }

            textBox1.AppendText(Environment.NewLine);
            foreach (int v in res) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);

        }

        private void button2_Click(object sender, EventArgs e)
        {
            List<int> q1 = new List<int> { 90, 30, 12, 2, 8, 211, 54 };
            q1.Sort();

            List<int> q2 = new List<int>{ 1, 23, 45, 76, 200, 400 };
            q2.Sort();

            foreach (int v in q1) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);
            foreach (int v in q2) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);

            List<int> res = new List<int>();

            while (q1.Count > 0 && q2.Count > 0)
            {
                if (q1[0] <= q2[0])
                {
                    res.Add(q1[0]);
                    q1.RemoveAt(0);
                }
                else
                {
                    res.Add(q2[0]);
                    q2.RemoveAt(0);
                }
            }
            if (q1.Count > 0)
            {
                res.AddRange(q1);
                q1.Clear();
            }
            else
            {
                res.AddRange(q2);
                q2.Clear();
            }

            textBox1.AppendText(Environment.NewLine);
            foreach (int v in res) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);

        }

        private void button3_Click(object sender, EventArgs e)
        {
            List<int> q1 = new List<int> { 90, 30, 12, 2, 8, 211, 54 };
            q1.Sort();

            List<int> q2 = new List<int> { 1, 23, 45, 76, 200, 400 };
            q2.Sort();

            foreach (int v in q1) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);
            foreach (int v in q2) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);

            List<int> res = new List<int>();

            int i, j;
            i = j = 0;
            while (i < q1.Count && j < q2.Count)
            {
                if (q1[i] <= q2[j])
                    res.Add(q1[i++]);
                else
                    res.Add(q2[j++]);
            }
            
            if (i < q1.Count)
                res.AddRange(q1.GetRange(i, q1.Count - i));
            else
                res.AddRange(q2.GetRange(j, q2.Count - j));

            textBox1.AppendText(Environment.NewLine);
            foreach (int v in res) textBox1.AppendText(v.ToString() + " ");
            textBox1.AppendText(Environment.NewLine);

        }

        static int CalcPolishNotation(Queue<string> pn_equation)
        {
            int a, b, c=0;
            Stack<int> working_stack = new Stack<int>();
            foreach (string ch in pn_equation)
            {
                if (ch == "*" || ch == "/" || ch == "+" || ch == "-")
                {
                    b = working_stack.Pop();
                    a = working_stack.Pop();
                    switch (ch)
                        {
                            case "*": c = a * b; break;
                            case "/": c = a / b; break;
                            case "-": c = a - b; break;
                            case "+": c = a + b; break;
                        }
                    working_stack.Push(c);
                }
                else if (ch == "~") // унарен минус
                {
                    a = working_stack.Pop();
                    working_stack.Push(-a);
                }
                else 
                {
                    working_stack.Push( int.Parse(ch) );
                }
            }
            return working_stack.Pop();
        }

        private void button4_Click(object sender, EventArgs e)
        {
            Queue<string> my_expr = new Queue<string>();
            
            my_expr.Enqueue("8");
            my_expr.Enqueue("~");
            my_expr.Enqueue("3");
            my_expr.Enqueue("7");
            my_expr.Enqueue("-");
            my_expr.Enqueue("*");

            // 8 ~ 3 7 - *  == -8 * (3-7)

            foreach (string v in my_expr)
                textBox1.AppendText(v + " ");

            textBox1.AppendText(" = " +
                CalcPolishNotation(my_expr) +
                Environment.NewLine);


        }

    }
}
