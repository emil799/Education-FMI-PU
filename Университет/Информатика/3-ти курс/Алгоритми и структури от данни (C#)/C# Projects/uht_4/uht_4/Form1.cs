using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace uht_4
{
    public partial class Form1 : Form
    {
        string pn_equation;

        public Form1()
        {
            InitializeComponent();
            pn_equation = "";
        }

        private void button1_Click(object sender, EventArgs e)
        {
            Random rand = new Random();
            Random rand1 = new Random();

            ulong n, n0;

            n = 1000000L;
            n0 = 0;
            double x, y;
            double delta = 0.000000000001; 

            for(ulong i = 0; i<n; i++)
            {
                x = rand.NextDouble();
                y = rand1.NextDouble();
                if (1 - x * x + y * y < delta &&
                    x * x + y * y - 1 < delta ||
                    x * x + y * y < 1) 
                n0++;
            }

            double pi = (double)n0 / n * 4;
            textBox1.AppendText("pi = " + pi.ToString());
            textBox1.AppendText(Environment.NewLine);
        }

        private void button2_Click(object sender, EventArgs e)
        {
            if (pn_equation == "")
            {
                textBox1.AppendText("No equation\n");
                return;
            }  

            int a, b;
            Stack<int> working_stack = new Stack<int>();
            
            foreach (char ch in pn_equation)
            {
                switch (ch)
                {
                    case '*': case '/': case '+': case '-':
                        b = working_stack.Pop();
                        a = working_stack.Pop();
                        switch (ch)
                        {
                            case '*': a *= b; break;
                            case '/': a /= b; break;
                            case '-': a -= b; break;
                            case '+': a += b; break;
                        }
                        working_stack.Push(a);
                        break;
                    case '~': // унарен минус
                        a = working_stack.Pop();
                        working_stack.Push(-a);
                        break;
                    default:
                        if (char.IsDigit(ch))
                            working_stack.Push(ch - '0');
                        break;
                }
            }
            textBox1.AppendText(pn_equation + " = " + working_stack.Pop());
        }

        private void button3_Click(object sender, EventArgs e)
        {
            string result = "";
            string inf_equation = textBoxIn.Text;
            char w_ch;
            Stack<char> working_stack = new Stack<char>();
            bool unary_minus = true;
            foreach (char ch in inf_equation)
            {
                switch (ch)
                {
                    case '*':
                    case '/':
                        // операциите * и / избутват всички * , / и ~ от стека
                        while (working_stack.Count > 0 &&
                        ((w_ch = working_stack.Peek()) == '*' ||
                        w_ch == '/' || w_ch == '~'))
                        {
                            result += working_stack.Pop().ToString() + ' ';
                        }
                        working_stack.Push(ch); unary_minus = true;
                        break;
                    case '+':
                    case '-':
                        // операциите + и - избутват всички операции до '('
                        if (unary_minus)
                        {
                            working_stack.Push('~');
                            break;
                        }
                        while (working_stack.Count > 0 &&
                        (w_ch = working_stack.Peek()) != '(')
                        {
                            result += working_stack.Pop().ToString() + ' ';
                        }
                        working_stack.Push(ch); unary_minus = true;
                        break;
                    case '(':
                        working_stack.Push(ch); unary_minus = true;
                        break;
                    case ')':
                        // избутва всички операции от стека до '('
                        while ((w_ch = working_stack.Pop()) != '(')
                            result += w_ch.ToString() + ' ';
                        unary_minus = true;
                        break;
                    default:
                        if (char.IsDigit(ch))
                        {
                            result += ch.ToString() + ' ';
                            unary_minus = false;
                        }
                        break;
                }
            }
            while (working_stack.Count > 0)
                result += working_stack.Pop().ToString() + ' ';

            textBox1.AppendText(inf_equation + " => ");
            pn_equation = result;
            button2_Click(sender, e);
        }

        private void button4_Click(object sender, EventArgs e)
        {
            Stack<int> my_stack = new Stack<int>();

            my_stack.Push(1);
            my_stack.Push(2);
            my_stack.Push(3);
            my_stack.Push(4);

            while (my_stack.Count > 0)
            {
                textBox1.AppendText(my_stack.Pop() + " ");
            }
            textBox1.AppendText(Environment.NewLine);
        }

        private void button5_Click(object sender, EventArgs e)
        {
            Queue<int> my_queue = new Queue<int>();

            my_queue.Enqueue(1);
            my_queue.Enqueue(2);
            my_queue.Enqueue(3);
            my_queue.Enqueue(4);

            while (my_queue.Count > 0)
            {
                textBox1.AppendText(my_queue.Dequeue() + " ");
            }
            textBox1.AppendText(Environment.NewLine);

        }

        // бройни системи -за реализация
    }
}
