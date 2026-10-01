using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace asd_l5
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        public class TStack
        {
            TNodeList _top;

            public TStack()
            {
                _top = null;
            }

            public void Clear()
            {
                _top = null;
            }

            public void Push(int v)
            {
                TNodeList new_se = new TNodeList(v, _top);
                new_se.SetNext(_top);
                _top = new_se; 
            }

            public void Push(TNodeList new_node)
            {
                new_node.SetNext(_top);
                _top = new_node;
            }

            public int Pop()
            {
                if (_top == null) return Int32.MinValue;
                int x = _top.GetValue();
                _top = _top.GetNext();
                return x;
            }
        }

        public class TNodeList
        {
            int _value;
            TNodeList _next;

            public TNodeList(int v)
            {
                _value = v;
                _next = null;
            }

            public TNodeList()
            {
                _next = null;
            }

            public TNodeList(int v, TNodeList nxt)
            {
                _value = v;
                _next = nxt;
            }

            public int GetValue()
            {
                return _value;
            }

            public TNodeList GetNext()
            {
                return _next;
            }

            public void SetNext(TNodeList next_node)
            {
                _next = next_node;
            }
        }

        private class TQueue
        {
            int[] _queue;
            int _first, _last;

            public TQueue(int n)
            {
                _queue = new int[n];
                _first = _last = 0;

            }

            public TQueue()
            {
                _queue = new int[100];
                _first = _last = 0;
            }

            public void Enqueue(int x)
            {
                if ((_last + 1) % _queue.Length == _first) return; 
                _queue[_last++] = x;
                _last %= _queue.Length;
            }

            public int Dequeue()
            {
                if (_first == _last) return Int32.MinValue;

                int x = _queue[_first++];
                _first %= _queue.Length;
                return x;
            }

            public int Count()
            {
                int x = _last - _first;
                if (x < 0) x += _queue.Length;
                return x;
            }

            public void Clear()
            {
                _first = _last = 0;
            }

        }


        public class TQueueByList
        {
            TNodeList _first;
            TNodeList _last;

            public TQueueByList()
            {
                _first = _last = null;
            }

            public void Clear()
            {
                _first = _last = null;
            }

            public void Enqueue(int v)
            {
                TNodeList new_se = new TNodeList(v, null);
                if (_last != null) _last.SetNext(new_se);
                _last = new_se;
                if (_first == null) _first = new_se;
            }

            public void Enqueue(TNodeList new_node)
            {
                if (_last != null) _last.SetNext(new_node);
                _last = new_node;
                if (_first == null) _first = new_node;
            }

            public int Dequeue()
            {
                if (_first == null) return Int32.MinValue;
                
                int x = _first.GetValue();
                _first = _first.GetNext();
                if (_first == null) _last = null;
                return x;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            //TStack my_stack = new TStack();

            Stack<int> my_stack = new Stack<int>();

            my_stack.Push(1);
            my_stack.Push(2);
            my_stack.Push(3);

            int x = my_stack.Pop();
            textBox1.AppendText(x + Environment.NewLine);

            textBox1.AppendText(my_stack.Pop() + Environment.NewLine);
            textBox1.AppendText(my_stack.Pop() + Environment.NewLine);

//            TQueue my_queue = new TQueue();
            TQueueByList my_queue = new TQueueByList();

            my_queue.Enqueue(1);
            my_queue.Enqueue(2);
            my_queue.Enqueue(3);
            my_queue.Enqueue(4);

            textBox1.AppendText(Environment.NewLine + 
                my_queue.Dequeue() + Environment.NewLine);
            textBox1.AppendText(my_queue.Dequeue() + Environment.NewLine);
            textBox1.AppendText(my_queue.Dequeue() + Environment.NewLine);
            textBox1.AppendText(my_queue.Dequeue() + Environment.NewLine);

        }
    }
}
